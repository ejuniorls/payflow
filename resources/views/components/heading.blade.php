@props([
    'level' => null,
    'size' => 'base',
])

@php
    $tag = in_array($level, [1, 2, 3, 4, 5, 6]) ? 'h' . $level : 'div';

    $sizes = [
        'base' => 'text-base',
        'lg' => 'text-lg',
        'xl' => 'text-2xl',
    ];
@endphp

<{{ $tag }} {{ $attributes->class(['font-semibold text-base-content', $sizes[$size] ?? $sizes['base']]) }}>
    {{ $slot }}
</{{ $tag }}>