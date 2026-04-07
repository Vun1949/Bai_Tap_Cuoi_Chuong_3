@extends('layouts.master')

@section('title', 'Lessons')
@section('page_title', 'Lessons')
@section('page_subtitle', 'Khóa học: '.$course->name)

@section('content')
    <div class="d-flex gap-2 mb-3">
        <a class="btn btn-outline-secondary" href="{{ route('courses.index') }}">Quay lại Courses</a>
        <a class="btn btn-primary" href="{{ route('courses.lessons.create', $course) }}">+ Thêm bài học</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 90px;">Order</th>
                            <th>Tiêu đề</th>
                            <th>Video</th>
                            <th class="text-end" style="width: 160px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lessons as $lesson)
                            <tr>
                                <td>{{ $lesson->order }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $lesson->title }}</div>
                                    @if ($lesson->content)
                                        <div class="text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($lesson->content), 120) }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($lesson->video_url)
                                        <a href="{{ $lesson->video_url }}" target="_blank" rel="noopener">Mở video</a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('courses.lessons.edit', [$course, $lesson]) }}">Sửa</a>
                                    <form class="d-inline" method="post" action="{{ route('courses.lessons.destroy', [$course, $lesson]) }}" onsubmit="return confirm('Xóa bài học?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-muted">Chưa có bài học.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

