@props([
    'variant' => 'default',
    'size' => 'sm',
])

@php
    $variants = [
        'default' => 'text-base-content/70',
        'subtle' => 'text-base-content/50',
        'success' => 'text-success',
        'error' => 'text-error',
    ];

    $sizes = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'base' => 'text-base',
    ];
@endphp

<p {{ $attributes->class([$variants[$variant] ?? $variants['default'], $sizes[$size] ?? $sizes['sm']]) }}>
    {{ $slot }}
</p>