@props([
    'icon' => null,
    'active' => false,
    'navigate' => true,
])

<li>
    <a {{ $attributes->class([
        'is-drawer-close:tooltip is-drawer-close:tooltip-right',
        'menu-active' => $active,
    ]) }} data-tip="{{ trim(strip_tags($slot)) }}" @if ($navigate) wire:navigate @endif>
        @if ($icon)
            <i class="{{ $icon }} w-4 text-center" aria-hidden="true"></i>
        @endif
        <span class="is-drawer-close:hidden">{{ $slot }}</span>
    </a>
</li>
