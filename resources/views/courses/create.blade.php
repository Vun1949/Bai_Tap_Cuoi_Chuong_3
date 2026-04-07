@extends('layouts.master')

@section('title', 'Thêm khóa học')
@section('page_title', 'Thêm khóa học')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('courses.store') }}" enctype="multipart/form-data" class="row g-3">
                @csrf
                <div class="col-md-8">
                    <label class="form-label">Tên khóa học *</label>
                    <input class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Trạng thái *</label>
                    <select class="form-select" name="status" required>
                        <option value="draft" @selected(old('status','draft')==='draft')>Draft</option>
                        <option value="published" @selected(old('status')==='published')>Published</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Giá *</label>
                    <input class="form-control" type="number" step="0.01" name="price" value="{{ old('price') }}" required>
                    <div class="form-text">Yêu cầu: giá &gt; 0</div>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Slug (tự sinh nếu bỏ trống)</label>
                    <input class="form-control" name="slug" value="{{ old('slug') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Mô tả</label>
                    <textarea class="form-control" rows="4" name="description">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Ảnh khóa học</label>
                    <input class="form-control" type="file" name="image" accept="image/*">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Lưu</button>
                    <a class="btn btn-outline-secondary" href="{{ route('courses.index') }}">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection

