<?php

use Livewire\Component;

new class extends Component { }; ?>

<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('Delete account') }}</flux:heading>
        <flux:subheading>{{ __('Delete your account and all of its resources') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <x-button color="error" data-test="delete-user-button">
            {{ __('Delete account') }}
        </x-button>
    </flux:modal.trigger>

    <livewire:pages::settings.delete-user-modal />
</section>