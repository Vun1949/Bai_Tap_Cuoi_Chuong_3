@extends('layouts.master')

@section('title', 'Enrollments')
@section('page_title', 'Enrollments')
@section('page_subtitle', 'Danh sách học viên đăng ký theo khóa học')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form method="get" action="{{ route('enrollments.index') }}" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Chọn khóa học</label>
                    <select class="form-select" name="course_id" onchange="this.form.submit()">
                        <option value="">-- Tất cả khóa học --</option>
                        @foreach ($courses as $c)
                            <option value="{{ $c->id }}" @selected((string)$courseId === (string)$c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 d-flex gap-2">
                    <a class="btn btn-success ms-auto" href="{{ route('enrollments.create', ['course_id' => $courseId]) }}">+ Đăng ký</a>
                </div>
            </form>
            <div class="text-muted small mt-2">
                Tổng số học viên (distinct): <span class="fw-semibold">{{ $totalStudents }}</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Học viên</th>
                            <th>Email</th>
                            <th>Khóa học</th>
                            <th>Enrolled at</th>
                            <th class="text-end" style="width: 120px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $e)
                            <tr>
                                <td class="fw-semibold">{{ $e->student->name }}</td>
                                <td>{{ $e->student->email }}</td>
                                <td>{{ $e->course->name }}</td>
                                <td class="text-muted small">{{ $e->enrolled_at }}</td>
                                <td class="text-end">
                                    <form method="post" action="{{ route('enrollments.destroy', $e) }}" onsubmit="return confirm('Hủy đăng ký?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">Hủy</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-muted">Chưa có đăng ký.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $enrollments->links() }}
            </div>
        </div>
    </div>
@endsection

