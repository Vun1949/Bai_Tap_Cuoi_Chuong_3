@props(['course'])

<div class="card h-100">
    <div class="card-body">
        <div class="d-flex gap-3">
            <div>
                @if ($course->image_path)
                    <img class="course-img" src="{{ asset('storage/'.$course->image_path) }}" alt="course">
                @else
                    <div class="course-img d-flex align-items-center justify-content-center text-muted small">No image</div>
                @endif
            </div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-start justify-content-between gap-2">
                    <div>
                        <div class="fw-semibold">{{ $course->name }}</div>
                        <div class="text-muted small">{{ number_format((float)$course->price, 0, ',', '.') }} đ</div>
                    </div>
                    <x-badge-status :status="$course->status" />
                </div>
                <div class="mt-2 text-muted small">
                    Lessons: <span class="fw-semibold">{{ $course->lessons_count ?? $course->lessons()->count() }}</span> •
                    Students: <span class="fw-semibold">{{ $course->enrollments_count ?? $course->enrollments()->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

