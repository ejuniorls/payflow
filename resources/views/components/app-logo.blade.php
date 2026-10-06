<a {{ $attributes->class(['flex items-center gap-2 px-2 font-semibold']) }}>
    <span class="flex size-8 items-center justify-center rounded-md bg-primary text-primary-content">
        <x-app-logo-icon class="size-5 fill-current" />
    </span>
    {{ config('app.name', 'Laravel') }}
</a>