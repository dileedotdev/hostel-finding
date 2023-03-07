<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    @if (auth()->user()->password)
        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label
                    for="current_password"
                    value="{{ __('Current Password') }}"
                />
                <x-jet-input
                    id="current_password"
                    type="password"
                    class="mt-1 block w-full"
                    wire:model.defer="state.current_password"
                    autocomplete="current-password"
                />
                <x-jet-input-error
                    for="current_password"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label
                    for="password"
                    value="{{ __('New Password') }}"
                />
                <x-jet-input
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    wire:model.defer="state.password"
                    autocomplete="new-password"
                />
                <x-jet-input-error
                    for="password"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label
                    for="password_confirmation"
                    value="{{ __('Confirm Password') }}"
                />
                <x-jet-input
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    wire:model.defer="state.password_confirmation"
                    autocomplete="new-password"
                />
                <x-jet-input-error
                    for="password_confirmation"
                    class="mt-2"
                />
            </div>

        </x-slot>
    @else
        <x-slot name="form">
            <x-alerts.warning class="col-span-6">
                <x-slot name="title">
                    {{ __('This function is not available!') }}
                </x-slot>

                {{ __('Because you logged in with your social account, you should logout and try reset password with your email!') }}
            </x-alerts.warning>
        </x-slot>
    @endif

    @if (auth()->user()->password)
        <x-slot name="actions">
            <x-jet-action-message
                class="mr-3"
                on="saved"
            >
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    @endif
</x-jet-form-section>
