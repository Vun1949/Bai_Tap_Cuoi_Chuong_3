@php
    $items = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => fn () => request()->routeIs('dashboard')],
        [
            'label' => 'Courses',
            'route' => 'courses.index',
            'active' => fn () => request()->routeIs('courses.*')
                && ! request()->routeIs('courses.lessons.*')
                && ! request()->routeIs('courses.trash'),
        ],
        [
            'label' => 'Lessons',
            'route' => 'courses.index',
            'active' => fn () => request()->routeIs('courses.lessons.*'),
            'title' => 'Mở 1 khóa học để xem Lessons',
            'sub' => 'Mở 1 khóa học để xem Lessons',
        ],
        ['label' => 'Enrollments', 'route' => 'enrollments.index', 'active' => fn () => request()->routeIs('enrollments.*')],
        ['label' => 'Courses (Trash)', 'route' => 'courses.trash', 'active' => fn () => request()->routeIs('courses.trash')],
    ];
@endphp

<nav class="nav nav-pills flex-column gap-1">
    @foreach ($items as $item)
        @php $isActive = ($item['active'])(); @endphp
        <div>
            <a
                class="nav-link {{ $isActive ? 'active' : 'text-dark' }}"
                href="{{ route($item['route']) }}"
                @isset($item['title']) title="{{ $item['title'] }}" @endisset
            >
                {{ $item['label'] }}
            </a>
            @isset($item['sub'])
                <div class="small text-muted ms-3 mt-1">{{ $item['sub'] }}</div>
            @endisset
        </div>
    @endforeach
</nav>

