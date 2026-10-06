<x-layouts::auth :title="__('Email verification')">
    <div class="mt-4 flex flex-col gap-6">
        <x-text class="text-center">
            {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
        </x-text>

        @if (session('status') == 'verification-link-sent')
            <x-text variant="success" class="text-center font-medium">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </x-text>
        @endif

        <div class="flex flex-col items-center justify-between space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-button type="submit" color="primary" block>
                    {{ __('Resend verification email') }}
                </x-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-button variant="ghost" size="sm" type="submit" data-test="logout-button">
                    {{ __('Log out') }}
                </x-button>
            </form>
        </div>
    </div>
</x-layouts::auth>