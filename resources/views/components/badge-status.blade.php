@props(['status'])

@php
    $map = [
        'draft' => ['label' => 'Draft', 'class' => 'text-bg-secondary'],
        'published' => ['label' => 'Published', 'class' => 'text-bg-success'],
    ];
    $item = $map[$status] ?? ['label' => $status, 'class' => 'text-bg-light'];
@endphp

<span class="badge {{ $item['class'] }}">{{ $item['label'] }}</span>

