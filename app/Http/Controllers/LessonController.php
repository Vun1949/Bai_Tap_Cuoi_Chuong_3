<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function index(Course $course): View
    {
        $lessons = $course->lessons()->orderBy('order')->get();

        return view('lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course): View
    {
        return view('lessons.create', compact('course'));
    }

    public function store(LessonRequest $request, Course $course): RedirectResponse
    {
        $data = $request->validated();
        $data['course_id'] = $course->id;

        Lesson::create($data);

        return redirect()->route('courses.lessons.index', $course)->with('success', 'Thêm bài học thành công.');
    }

    public function edit(Course $course, Lesson $lesson): View
    {
        abort_unless($lesson->course_id === $course->id, 404);

        return view('lessons.edit', compact('course', 'lesson'));
    }

    public function update(LessonRequest $request, Course $course, Lesson $lesson): RedirectResponse
    {
        abort_unless($lesson->course_id === $course->id, 404);

        $data = $request->validated();
        $data['course_id'] = $course->id;

        $lesson->update($data);

        return redirect()->route('courses.lessons.index', $course)->with('success', 'Cập nhật bài học thành công.');
    }

    public function destroy(Course $course, Lesson $lesson): RedirectResponse
    {
        abort_unless($lesson->course_id === $course->id, 404);

        $lesson->delete();

        return redirect()->route('courses.lessons.index', $course)->with('success', 'Đã xóa bài học.');
    }
}
