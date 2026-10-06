<?php

use Livewire\Component;

new class extends Component { }; ?>

<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <x-heading>{{ __('Delete account') }}</x-heading>
        <x-text variant="subtle">{{ __('Delete your account and all of its resources') }}</x-text>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <x-button color="error" data-test="delete-user-button">
            {{ __('Delete account') }}
        </x-button>
    </flux:modal.trigger>

    <livewire:pages::settings.delete-user-modal />
</section>