<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-base-100">
    <div class="drawer lg:drawer-open">
        <input id="app-drawer" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content flex min-h-screen flex-col">
            {{-- Barra superior, só no celular --}}
            <div class="navbar border-b border-base-300 lg:hidden">
                <label for="app-drawer" class="btn btn-ghost btn-square" aria-label="{{ __('Abrir menu') }}">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </label>
                <div class="flex-1"></div>
                <x-user-menu compact />
            </div>

            <main class="flex-1 p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>

        <div class="drawer-side z-40">
            <label for="app-drawer" class="drawer-overlay" aria-label="{{ __('Fechar menu') }}"></label>

            <aside class="flex min-h-full w-64 flex-col border-e border-base-300 bg-base-200 p-4">
                <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

                <ul class="menu mt-6 w-full gap-1 p-0">
                    <li class="menu-title">{{ __('Platform') }}</li>
                    <x-sidebar-item icon="fa-solid fa-house" :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-sidebar-item>

                    @can('access-admin')
                        <li class="menu-title mt-4">{{ __('Administração') }}</li>
                        <x-sidebar-item icon="fa-solid fa-gear" :href="route('admin.dashboard')"
                            :active="request()->routeIs('admin.*')">
                            {{ __('Painel') }}
                        </x-sidebar-item>
                    @endcan
                </ul>

                <ul class="menu mt-auto w-full p-0">
                    <x-sidebar-item icon="fa-brands fa-github" href="https://github.com/laravel/livewire-starter-kit"
                        target="_blank" :navigate="false">
                        {{ __('Repository') }}
                    </x-sidebar-item>
                    <x-sidebar-item icon="fa-solid fa-book-open" href="https://laravel.com/docs/starter-kits#livewire"
                        target="_blank" :navigate="false">
                        {{ __('Documentation') }}
                    </x-sidebar-item>
                </ul>

                <x-user-menu class="mt-4 w-full" />
            </aside>
        </div>
    </div>

    @persist('toast')
    <flux:toast.group>
        <flux:toast />
    </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>