@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <x-heading size="xl" level="1">{{ $title }}</x-heading>
    <x-text variant="subtle">{{ $description }}</x-text>
</div>
