@extends('layouts.master')

@section('title', 'Courses')
@section('page_title', 'Courses')
@section('page_subtitle', 'Danh sách khóa học + tìm kiếm/lọc/sắp xếp')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form class="row g-2 align-items-end" method="get" action="{{ route('courses.index') }}">
                <div class="col-md-4">
                    <label class="form-label">Tên khóa học</label>
                    <input class="form-control" name="q" value="{{ $q }}" placeholder="Nhập tên...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Trạng thái</label>
                    <select class="form-select" name="status">
                        <option value="">-- Tất cả --</option>
                        <option value="draft" @selected($status==='draft')>Draft</option>
                        <option value="published" @selected($status==='published')>Published</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Giá từ</label>
                    <input class="form-control" type="number" step="0.01" name="min_price" value="{{ $minPrice }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Giá đến</label>
                    <input class="form-control" type="number" step="0.01" name="max_price" value="{{ $maxPrice }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sắp xếp</label>
                    <select class="form-select" name="sort">
                        <option value="created_desc" @selected($sort==='created_desc')>Mới nhất</option>
                        <option value="created_asc" @selected($sort==='created_asc')>Cũ nhất</option>
                        <option value="price_asc" @selected($sort==='price_asc')>Giá tăng</option>
                        <option value="price_desc" @selected($sort==='price_desc')>Giá giảm</option>
                        <option value="students_desc" @selected($sort==='students_desc')>Nhiều học viên</option>
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Tìm</button>
                    <a class="btn btn-outline-secondary" href="{{ route('courses.index') }}">Reset</a>
                    <a class="btn btn-success ms-auto" href="{{ route('courses.create') }}">+ Thêm khóa học</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Tên</th>
                            <th class="text-end">Giá</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Số bài học</th>
                            <th class="text-end">Số học viên</th>
                            <th class="text-end" style="width: 220px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses as $course)
                            <tr>
                                <td>
                                    @if ($course->image_path)
                                        <img class="course-img" src="{{ asset('storage/'.$course->image_path) }}" alt="course">
                                    @else
                                        <div class="course-img d-flex align-items-center justify-content-center text-muted small">No</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $course->name }}</div>
                                    <div class="text-muted small">Slug: {{ $course->slug }}</div>
                                </td>
                                <td class="text-end">{{ number_format((float)$course->price, 0, ',', '.') }} đ</td>
                                <td><x-badge-status :status="$course->status" /></td>
                                <td class="text-end">{{ $course->lessons_count }}</td>
                                <td class="text-end">{{ $course->enrollments_count }}</td>
                                <td class="text-end">
                                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('courses.lessons.index', $course) }}">Lessons</a>
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('courses.edit', $course) }}">Sửa</a>
                                    <form class="d-inline" method="post" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Xóa khóa học? (soft delete)')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">Chưa có khóa học.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
@endsection

