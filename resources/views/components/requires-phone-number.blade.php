@props([
    'title' => __('Provide Phone Number'),
    'content' => __('This feature requires a phone number. Please provide one to continue.'),
    'button' => __('Confirm'),
])
<span x-data="requires_phone_number">
    <span
        x-ref="root_requires_phone_number"
        {{ $attributes->filter(fn($value, $key) => Str::startsWith($key, ['wire:then', 'x-on:then', '@then'])) }}
        @click="startRequirePhoneNumber"
    >
        {{ $slot }}
    </span>

    <x-jet-dialog-modal wire:model="isProvidingPhoneNumber">
        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="content">
            {{ $content }}

            <div
                class="mt-4"
                x-data="{}"
            >
                <x-jet-input
                    wire:model.defer="providingPhoneNumber"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Phone Number') }}"
                    @keydown.enter="requirePhoneNumber"
                />

                <x-jet-input-error
                    for="providingPhoneNumber"
                    class="mt-2"
                />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button
                @click="stopRequirePhoneNumber"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button
                class="ml-3"
                dusk="require-phone-number-button"
                wire:loading.attr="disabled"
                @click="providePhoneNumber"
            >
                {{ $button }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</span>

@push('scripts')
    @once
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('requires_phone_number', () => ({
                    async startRequirePhoneNumber() {
                        const result = await this.$wire.startRequirePhoneNumber();
                        result && this.$refs.root_requires_phone_number.dispatchEvent(new CustomEvent(
                            'then', {}));
                    },
                    async providePhoneNumber() {
                        const gRecaptchaResponse = await window.executeRecaptchaV3(
                            'provide_phone_number');
                        const result = await this.$wire.providePhoneNumber(gRecaptchaResponse);
                        result && this.$refs.root_requires_phone_number.dispatchEvent(new CustomEvent(
                            'then', {}));
                    },
                    async stopRequirePhoneNumber() {
                        await this.$wire.stopRequirePhoneNumber();
                        console.log('stopRequirePhoneNumber', this.$wire.isProvidingPhoneNumber);
                    }
                }));
            });
        </script>
    @endonce
@endpush
