@props([
    'icon' => null,
    'active' => false,
    'navigate' => true,
])

<li>
    <a {{ $attributes->class(['menu-active' => $active]) }} @if ($navigate) wire:navigate @endif>
        @if ($icon)
            <i class="{{ $icon }} w-4 text-center" aria-hidden="true"></i>
        @endif
        {{ $slot }}
    </a>
</li>