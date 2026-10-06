<a {{ $attributes->class(['flex items-center gap-2 px-1 font-semibold']) }}>
    <span class="flex size-8 shrink-0 items-center justify-center rounded-md bg-primary text-primary-content">
        <x-app-logo-icon class="size-5 fill-current" />
    </span>
    <span class="is-drawer-close:hidden">{{ config('app.name', 'Laravel') }}</span>
</a>
