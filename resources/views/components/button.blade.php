@props([
    'color' => null,
    'variant' => null,
    'size' => null,
    'shape' => null,
    'wide' => false,
    'block' => false,
    'active' => false,
])

@php
    $colors = [
        'neutral' => 'btn-neutral',
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'accent' => 'btn-accent',
        'info' => 'btn-info',
        'success' => 'btn-success',
        'warning' => 'btn-warning',
        'error' => 'btn-error',
    ];

    $variants = [
        'outline' => 'btn-outline',
        'dash' => 'btn-dash',
        'soft' => 'btn-soft',
        'ghost' => 'btn-ghost',
        'link' => 'btn-link',
    ];

    $sizes = [
        'xs' => 'btn-xs',
        'sm' => 'btn-sm',
        'md' => 'btn-md',
        'lg' => 'btn-lg',
        'xl' => 'btn-xl',
    ];

    $shapes = [
        'square' => 'btn-square',
        'circle' => 'btn-circle',
    ];

    $classes = Arr::toCssClasses([
        'btn',
        $colors[$color ?? ''] ?? null,
        $variants[$variant ?? ''] ?? null,
        $sizes[$size ?? ''] ?? null,
        $shapes[$shape ?? ''] ?? null,
        'btn-wide' => $wide,
        'btn-block' => $block,
        'btn-active' => $active,
    ]);
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
    {{ $slot }}
</button>