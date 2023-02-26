<x-header {{ $attributes }}>
    <form
        x-data="components_header_guest"
        @submit.prevent="search()"
        class="flex flex-1 items-center justify-between gap-2 rounded-full px-4 py-2 shadow-md md:w-[30vw] md:min-w-[380px] md:flex-initial"
    >
        <input
            x-ref="search"
            type="text"
            name="address"
            placeholder="Nhập địa điểm"
            class="flex-1 border-transparent focus:border-transparent focus:ring-0"
        />
        <button
            type="submit"
            class="rounded-full bg-primary-500 p-2"
            id="header-search-button"
        >
            <x-heroicon-o-search class="h-5 w-5 text-white" />
        </button>
    </form>
</x-header>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('components_header_guest', () => ({
                autocomplete: null,
                geocoder: null,
                async init() {
                    const google = await window.useGoogleMaps();

                    this.autocomplete = new google.maps.places.Autocomplete(this.$refs.search, {
                        componentRestrictions: {
                            country: 'VN'
                        },
                        fields: ['address_components', 'geometry', 'icon', 'name'],
                        strictBounds: false,
                    });

                    this.autocomplete.addListener('place_changed', () => {
                        const place = this.autocomplete.getPlace();
                        const lat = place.geometry?.location.lat();
                        const lng = place.geometry?.location.lng();

                        this.search(lat, lng);
                    });

                    this.geocoder = new google.maps.Geocoder();
                },
                async search(lat, lng, address) {
                    address ??= this.$refs.search.value;

                    if (!lat || !lng) {
                        try {
                            const {
                                results
                            } = await this.geocoder.geocode({
                                address,
                            });
                            lat = results[0].geometry.location.lat();
                            lng = results[0].geometry.location.lng();
                        } catch (e) {
                            const {
                                data
                            } = await window.axios.get('http://ip-api.com/json');
                            lat = data.lat;
                            lng = data.lon;
                            address = data.regionName;
                        }
                    }

                    const north = lat + 0.015;
                    const south = lat - 0.015;
                    const east = lng + 0.015;
                    const west = lng - 0.015;

                    window.location.href = @json(route('hostels.search')) +
                        '?address=' + address +
                        '&north=' + north +
                        '&south=' + south +
                        '&east=' + east +
                        '&west=' + west;
                }
            }))
        })
    </script>
@endpush
