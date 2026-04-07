@php
    $type = null;
    $message = null;

    foreach (['success', 'error', 'warning', 'info'] as $key) {
        if (session()->has($key)) {
            $type = $key === 'error' ? 'danger' : $key;
            $message = session($key);
            break;
        }
    }
@endphp

@if ($message)
    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <div class="fw-semibold mb-1">Dữ liệu không hợp lệ:</div>
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

