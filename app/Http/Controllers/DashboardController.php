<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalCourses = Course::query()->count();
        $totalStudents = Student::query()->count();

        $totalRevenue = (float) Enrollment::query()
            ->join('courses', 'courses.id', '=', 'enrollments.course_id')
            ->sum('courses.price');

        $topCourse = Course::query()
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->first();

        $latestCourses = Course::query()
            ->withCount('enrollments')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $revenueByCourse = Course::query()
            ->leftJoin('enrollments', 'enrollments.course_id', '=', 'courses.id')
            ->whereNull('courses.deleted_at')
            ->select([
                'courses.*',
                DB::raw('COUNT(enrollments.id) as enrollments_count'),
                DB::raw('courses.price * COUNT(enrollments.id) as revenue'),
            ])
            ->groupBy('courses.id')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'totalCourses',
            'totalStudents',
            'totalRevenue',
            'topCourse',
            'latestCourses',
            'revenueByCourse',
        ));
    }
}
