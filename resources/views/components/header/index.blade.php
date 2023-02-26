<header {{ $attributes->class('bg-white py-4') }}>

    <x-container class="flex items-center justify-between">
        {{-- logo --}}
        <a
            class="hidden md:block"
            href="{{ url('') }}"
        >
            <img
                src="https://laravel.com/img/logotype.min.svg"
                alt="logo"
                class="h-7"
            >
        </a>

        {{ $slot }}

        {{-- menu & dropdown --}}
        <div
            x-data="{
                show: false,
            }"
            class="relative ml-3 hidden md:block"
        >
            <div @click="show = !show">
                @auth
                    <button
                        type="button"
                        class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 lg:rounded-md lg:p-2 lg:hover:bg-gray-50"
                        aria-expanded="false"
                        aria-haspopup="true"
                    >
                        <img
                            class="h-11 w-11 rounded-full lg:h-8 lg:w-8"
                            src="{{ auth()->user()->profile_photo_url }}"
                            alt="avatar"
                        >
                        <span class="ml-3 hidden text-sm font-medium text-gray-700 lg:block">
                            <span class="sr-only">
                                Open user menu for
                            </span>
                            {{ auth()->user()->name }}
                        </span>
                        <svg
                            class="ml-1 hidden h-5 w-5 flex-shrink-0 text-gray-400 lg:block"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                @else
                    <button
                        class="rounded-full border p-3 shadow focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                        type="button"
                        aria-expanded="false"
                        aria-label="Main navigation menu"
                        data-testid="cypress-headernav-profile"
                    >
                        <div>
                            <svg
                                class="h-8 w-8 text-gray-500"
                                viewBox="0 0 32 32"
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                                role="presentation"
                                focusable="false"
                                style="display: block; fill: currentcolor;"
                            >
                                <path
                                    d="m16 .7c-8.437 0-15.3 6.863-15.3 15.3s6.863 15.3 15.3 15.3 15.3-6.863 15.3-15.3-6.863-15.3-15.3-15.3zm0 28c-4.021 0-7.605-1.884-9.933-4.81a12.425 12.425 0 0 1 6.451-4.4 6.507 6.507 0 0 1 -3.018-5.49c0-3.584 2.916-6.5 6.5-6.5s6.5 2.916 6.5 6.5a6.513 6.513 0 0 1 -3.019 5.491 12.42 12.42 0 0 1 6.452 4.4c-2.328 2.925-5.912 4.809-9.933 4.809z"
                                >
                                </path>
                            </svg>
                        </div>
                    </button>
                @endauth
            </div>

            <div
                x-cloak
                x-show="show"
                @click.outside="show = false"
                x-transition
                class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="user-menu-button"
                tabindex="-1"
            >
                @auth
                    <a
                        href="{{ route('profile.show') }}"
                        class="block px-4 py-2 text-sm text-gray-700"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0"
                    >
                        Hồ sơ
                    </a>
                    @can('create', App\Models\Hostel::class)
                        <a
                            href="{{ App\Filament\Resources\MyHostelResource::getUrl('create') }}"
                            class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem"
                            tabindex="-1"
                            id="user-menu-item-0"
                        >
                            Đăng nhà trọ
                        </a>
                        <a
                            href="{{ App\Filament\Resources\MyHostelResource::getUrl('index') }}"
                            class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem"
                            tabindex="-1"
                            id="user-menu-item-0"
                        >
                            Quản lý nhà trọ
                        </a>
                    @endcan
                    <form
                        x-data
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf
                        <a
                            class="block px-4 py-2 text-sm text-gray-700"
                            href="{{ route('logout') }}"
                            @click.prevent="$root.submit();"
                        >
                            Đăng xuất
                        </a>
                    </form>
                @else
                    <a
                        href="{{ route('register') }}"
                        class="block px-4 py-2 text-sm text-gray-700"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-1"
                    >
                        Đăng ký
                    </a>
                    <a
                        href="{{ route('login') }}"
                        class="block px-4 py-2 text-sm text-gray-700"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-2"
                    >
                        Đăng nhập
                    </a>
                @endauth
            </div>
        </div>
    </x-container>
</header>
