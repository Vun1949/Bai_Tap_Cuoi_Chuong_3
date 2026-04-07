@extends('layouts.master')

@section('title', 'Đăng ký khóa học')
@section('page_title', 'Đăng ký khóa học')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('enrollments.store') }}" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label class="form-label">Khóa học *</label>
                    <select class="form-select" name="course_id" required>
                        <option value="">-- Chọn khóa học --</option>
                        @foreach ($courses as $c)
                            <option value="{{ $c->id }}" @selected(old('course_id', $courseId) == $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <label class="form-label">Tên học viên *</label>
                    <input class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email *</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Đăng ký</button>
                    <a class="btn btn-outline-secondary" href="{{ route('enrollments.index', ['course_id' => old('course_id', $courseId)]) }}">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection

