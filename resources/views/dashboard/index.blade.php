@extends('layouts.master')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Tổng quan hệ thống quản lý khóa học')

@section('content')
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted small">Tổng số khóa học</div>
                    <div class="h4 mb-0">{{ $totalCourses }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted small">Tổng số học viên</div>
                    <div class="h4 mb-0">{{ $totalStudents }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted small">Tổng doanh thu</div>
                    <div class="h4 mb-0">{{ number_format((float)$totalRevenue, 0, ',', '.') }} đ</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-white">
                    Khóa học nhiều học viên nhất
                </div>
                <div class="card-body">
                    @if ($topCourse)
                        <x-course-card :course="$topCourse" />
                        <div class="mt-3">
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('courses.edit', $topCourse) }}">Sửa khóa học</a>
                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('courses.lessons.index', $topCourse) }}">Xem lessons</a>
                        </div>
                    @else
                        <div class="text-muted">Chưa có dữ liệu.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-white">5 khóa học mới</div>
                <div class="card-body">
                    <div class="row g-3">
                        @forelse ($latestCourses as $c)
                            <div class="col-12">
                                <x-course-card :course="$c" />
                            </div>
                        @empty
                            <div class="text-muted">Chưa có dữ liệu.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-white">Thống kê (Advanced)</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Khóa học</th>
                            <th class="text-end">Giá</th>
                            <th class="text-end">Số học viên</th>
                            <th class="text-end">Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($revenueByCourse as $c)
                            <tr>
                                <td>{{ $c->name }}</td>
                                <td class="text-end">{{ number_format((float)$c->price, 0, ',', '.') }} đ</td>
                                <td class="text-end">{{ $c->enrollments_count }}</td>
                                <td class="text-end">{{ number_format((float)($c->revenue ?? 0), 0, ',', '.') }} đ</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-muted">Chưa có dữ liệu.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

