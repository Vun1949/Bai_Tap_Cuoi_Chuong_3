@extends('layouts.master')

@section('title', 'Sửa khóa học')
@section('page_title', 'Sửa khóa học')
@section('page_subtitle', $course->name)

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex gap-3 align-items-start">
                <div>
                    @if ($course->image_path)
                        <img class="course-img" src="{{ asset('storage/'.$course->image_path) }}" alt="course">
                    @else
                        <div class="course-img d-flex align-items-center justify-content-center text-muted small">No image</div>
                    @endif
                </div>
                <div>
                    <div class="fw-semibold">{{ $course->name }}</div>
                    <div class="text-muted small">Slug: {{ $course->slug }}</div>
                    <div class="mt-1">
                        <x-badge-status :status="$course->status" />
                    </div>
                </div>
                <div class="ms-auto">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('courses.lessons.index', $course) }}">Quản lý Lessons</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('courses.update', $course) }}" enctype="multipart/form-data" class="row g-3">
                @csrf
                @method('PUT')
                <div class="col-md-8">
                    <label class="form-label">Tên khóa học *</label>
                    <input class="form-control" name="name" value="{{ old('name', $course->name) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Trạng thái *</label>
                    <select class="form-select" name="status" required>
                        <option value="draft" @selected(old('status',$course->status)==='draft')>Draft</option>
                        <option value="published" @selected(old('status',$course->status)==='published')>Published</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Giá *</label>
                    <input class="form-control" type="number" step="0.01" name="price" value="{{ old('price', $course->price) }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Slug</label>
                    <input class="form-control" name="slug" value="{{ old('slug', $course->slug) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Mô tả</label>
                    <textarea class="form-control" rows="4" name="description">{{ old('description', $course->description) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Đổi ảnh khóa học</label>
                    <input class="form-control" type="file" name="image" accept="image/*">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Cập nhật</button>
                    <a class="btn btn-outline-secondary" href="{{ route('courses.index') }}">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection

