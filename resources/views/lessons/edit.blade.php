@extends('layouts.master')

@section('title', 'Sửa bài học')
@section('page_title', 'Sửa bài học')
@section('page_subtitle', 'Khóa học: '.$course->name)

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('courses.lessons.update', [$course, $lesson]) }}" class="row g-3">
                @csrf
                @method('PUT')
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                <div class="col-md-8">
                    <label class="form-label">Tiêu đề *</label>
                    <input class="form-control" name="title" value="{{ old('title', $lesson->title) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Thứ tự (order)</label>
                    <input class="form-control" type="number" name="order" value="{{ old('order', $lesson->order) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Video URL</label>
                    <input class="form-control" name="video_url" value="{{ old('video_url', $lesson->video_url) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Nội dung</label>
                    <textarea class="form-control" rows="6" name="content">{{ old('content', $lesson->content) }}</textarea>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Cập nhật</button>
                    <a class="btn btn-outline-secondary" href="{{ route('courses.lessons.index', $course) }}">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection

