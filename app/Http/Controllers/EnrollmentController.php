<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentRequest;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function index(Request $request): View
    {
        $courseId = $request->query('course_id');

        $courses = Course::query()->orderBy('name')->get();

        $enrollmentsQuery = Enrollment::query()
            ->with(['course', 'student']);

        if ($courseId) {
            $enrollmentsQuery->where('course_id', (int) $courseId);
        }

        $enrollments = $enrollmentsQuery
            ->orderByDesc('enrolled_at')
            ->paginate(10)
            ->withQueryString();

        $totalStudents = (clone $enrollmentsQuery)->distinct('student_id')->count('student_id');

        return view('enrollments.index', compact('enrollments', 'courses', 'courseId', 'totalStudents'));
    }

    public function create(Request $request): View
    {
        $courses = Course::query()->orderBy('name')->get();
        $courseId = $request->query('course_id');

        return view('enrollments.create', compact('courses', 'courseId'));
    }

    public function store(EnrollmentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $student = Student::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name'], 'email' => $data['email']]
        );

        $exists = Enrollment::query()
            ->where('course_id', (int) $data['course_id'])
            ->where('student_id', $student->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Học viên đã đăng ký khóa học này rồi.');
        }

        Enrollment::create([
            'course_id' => (int) $data['course_id'],
            'student_id' => $student->id,
        ]);

        return redirect()->route('enrollments.index', ['course_id' => $data['course_id']])->with('success', 'Đăng ký khóa học thành công.');
    }

    public function destroy(Enrollment $enrollment): RedirectResponse
    {
        $courseId = $enrollment->course_id;
        $enrollment->delete();

        return redirect()->route('enrollments.index', ['course_id' => $courseId])->with('success', 'Đã hủy đăng ký.');
    }
}
