@props([
    'label' => null,
    'color' => null,
    'size' => null,
    'indeterminate' => false,
])

@php
    $colors = [
        'primary' => 'checkbox-primary',
        'secondary' => 'checkbox-secondary',
        'accent' => 'checkbox-accent',
        'neutral' => 'checkbox-neutral',
        'success' => 'checkbox-success',
        'warning' => 'checkbox-warning',
        'info' => 'checkbox-info',
        'error' => 'checkbox-error',
    ];

    $sizes = [
        'xs' => 'checkbox-xs',
        'sm' => 'checkbox-sm',
        'md' => 'checkbox-md',
        'lg' => 'checkbox-lg',
        'xl' => 'checkbox-xl',
    ];

    $classes = Arr::toCssClasses([
        'checkbox',
        $colors[$color ?? ''] ?? null,
        $sizes[$size ?? ''] ?? null,
    ]);

    $disabled = (bool) $attributes->get('disabled');
@endphp

<label @class(['label gap-2', 'cursor-pointer' => ! $disabled, 'cursor-not-allowed' => $disabled])>
    <input
        type="checkbox"
        @if ($indeterminate) x-data x-init="$el.indeterminate = true" @endif
        {{ $attributes->class($classes) }}
    />
    @if ($label)
        <span>{{ $label }}</span>
    @endif
</label>
