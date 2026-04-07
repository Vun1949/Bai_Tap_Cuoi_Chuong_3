<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $status = $request->query('status');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $sort = (string) $request->query('sort', 'created_desc');

        $courses = Course::query()
            ->with(['lessons', 'enrollments'])
            ->withCount(['lessons', 'enrollments'])
            ->when($q !== '', fn ($query) => $query->where('name', 'like', "%{$q}%"))
            ->when(in_array($status, ['draft', 'published'], true), fn ($query) => $query->where('status', $status))
            ->when($minPrice !== null || $maxPrice !== null, fn ($query) => $query->priceBetween(
                $minPrice !== null && $minPrice !== '' ? (float) $minPrice : null,
                $maxPrice !== null && $maxPrice !== '' ? (float) $maxPrice : null
            ))
            ->when($sort === 'price_asc', fn ($query) => $query->orderBy('price', 'asc'))
            ->when($sort === 'price_desc', fn ($query) => $query->orderBy('price', 'desc'))
            ->when($sort === 'students_desc', fn ($query) => $query->orderBy('enrollments_count', 'desc'))
            ->when($sort === 'created_asc', fn ($query) => $query->orderBy('created_at', 'asc'))
            ->when($sort === 'created_desc', fn ($query) => $query->orderBy('created_at', 'desc'))
            ->paginate(10)
            ->withQueryString();

        return view('courses.index', compact('courses', 'q', 'status', 'minPrice', 'maxPrice', 'sort'));
    }

    public function create(): View
    {
        return view('courses.create');
    }

    public function store(CourseRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('courses', 'public');
        }

        Course::create($data);

        return redirect()->route('courses.index')->with('success', 'Tạo khóa học thành công.');
    }

    public function edit(Course $course): View
    {
        return view('courses.edit', compact('course'));
    }

    public function update(CourseRequest $request, Course $course): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            $data['image_path'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('courses.index')->with('success', 'Cập nhật khóa học thành công.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Đã xóa (soft delete) khóa học.');
    }

    public function trash(): View
    {
        $courses = Course::onlyTrashed()
            ->with(['lessons', 'enrollments'])
            ->withCount(['lessons', 'enrollments'])
            ->orderByDesc('deleted_at')
            ->paginate(10);

        return view('courses.trash', compact('courses'));
    }

    public function restore(int $course): RedirectResponse
    {
        Course::onlyTrashed()->findOrFail($course)->restore();

        return redirect()->route('courses.trash')->with('success', 'Khôi phục khóa học thành công.');
    }
}
