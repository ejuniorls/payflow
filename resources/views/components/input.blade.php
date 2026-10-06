@props([
    'label' => null,
    'name' => null,
])

@php
    $errorKey = $name ?? ($attributes->wire('model')->value() ?: null);
    $hasError = $errorKey && $errors->has($errorKey);
@endphp

<fieldset class="fieldset">
    @if ($label)
        <legend class="fieldset-legend">{{ $label }}</legend>
    @endif

    <input @if ($name) name="{{ $name }}" id="{{ $name }}" @endif {{ $attributes->class(['input w-full', 'input-error' => $hasError]) }} />

    @if ($errorKey)
        @error($errorKey)
            <p class="label text-error">{{ $message }}</p>
        @enderror
    @endif
</fieldset>
