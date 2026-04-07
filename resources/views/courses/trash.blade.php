@extends('layouts.master')

@section('title', 'Courses Trash')
@section('page_title', 'Courses Trash')
@section('page_subtitle', 'Khóa học đã xóa (soft delete) và khôi phục')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tên</th>
                            <th class="text-end">Giá</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Bài học</th>
                            <th class="text-end">Học viên</th>
                            <th>Deleted at</th>
                            <th class="text-end" style="width: 120px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses as $course)
                            <tr>
                                <td>{{ $course->name }}</td>
                                <td class="text-end">{{ number_format((float)$course->price, 0, ',', '.') }} đ</td>
                                <td><x-badge-status :status="$course->status" /></td>
                                <td class="text-end">{{ $course->lessons_count }}</td>
                                <td class="text-end">{{ $course->enrollments_count }}</td>
                                <td class="text-muted small">{{ $course->deleted_at }}</td>
                                <td class="text-end">
                                    <form method="post" action="{{ route('courses.restore', $course->id) }}">
                                        @csrf
                                        <button class="btn btn-outline-success btn-sm">Restore</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-muted">Không có khóa học trong thùng rác.</td></tr>
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

