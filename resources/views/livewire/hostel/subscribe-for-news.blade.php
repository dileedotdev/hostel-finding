<div x-data="livewire_hostel_subscribe_for_news">
    <button
        class="inline-block w-full items-center rounded-md border border-transparent bg-primary-600 px-6 py-3 text-center text-lg font-bold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        @click="subscribe"
    >
        Đăng Ký Nhận Tin
    </button>
</div>

@push('scripts')
    @once
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('livewire_hostel_subscribe_for_news', () => ({
                    async subscribe() {
                        this.$wire.subscribe(await window.executeRecaptchaV3(
                            'livewire_hostel_subscribe_for_news'));
                    }
                }))
            });
        </script>
    @endonce
@endpush
