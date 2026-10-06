@props([
    'compact' => false,
])

@php
    $user = auth()->user();
    $logoutForm = 'logout-form-' . Str::random(6);
@endphp

<div {{ $attributes->class(['dropdown', 'dropdown-top' => !$compact, 'dropdown-end' => $compact]) }}>
    <div tabindex="0" role="button" data-test="sidebar-menu-button" @class([
        'btn btn-ghost',
        'w-full justify-start gap-3 px-2' => !$compact,
        'btn-circle' => $compact,
    ])>
        <div class="avatar avatar-placeholder">
            <div class="w-8 rounded-full bg-neutral text-neutral-content">
                <span class="text-xs">{{ $user->initials() }}</span>
            </div>
        </div>

        @unless ($compact)
            <span class="flex-1 truncate text-start">{{ $user->name }}</span>
            <i class="fa-solid fa-chevron-up text-xs opacity-60" aria-hidden="true"></i>
        @endunless
    </div>

    <div tabindex="0" @class([
        'dropdown-content z-50 w-60 rounded-box border border-base-300 bg-base-100 p-2 shadow-lg',
        'mb-2' => !$compact,
        'mt-2' => $compact,
    ])>
        <div class="px-2 py-1.5">
            <p class="truncate text-sm font-semibold">{{ $user->name }}</p>
            <p class="truncate text-xs opacity-60">{{ $user->email }}</p>
        </div>

        <div class="divider my-1"></div>

        <ul class="menu w-full p-0">
            <li>
                <a href="{{ route('profile.edit') }}" wire:navigate>
                    <i class="fa-solid fa-gear w-4 text-center" aria-hidden="true"></i>
                    {{ __('Settings') }}
                </a>
            </li>
            <li>
                <button type="submit" form="{{ $logoutForm }}" data-test="logout-button">
                    <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center" aria-hidden="true"></i>
                    {{ __('Log out') }}
                </button>
            </li>
        </ul>
    </div>

    <form id="{{ $logoutForm }}" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>
</div>