<div
    x-data="chat"
    class="flex flex-col items-end"
>

    @php
        $height = 'min-h-[700px]';
    @endphp
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="{{ $height }} mb-6 w-[360px] max-w-[calc(100vw-36px)] origin-bottom-right rounded-md border border-slate-200 bg-slate-50 shadow"
    >
        @if (Auth::check())
            <div class="{{ $height }} flex flex-1 flex-col">

                <div class="p-2">
                    <ul class="flex items-end gap-2 overflow-auto">
                        {{-- foreach 10 times --}}
                        @foreach (range(0, 4) as $i)
                            <li>
                                <button
                                    type="button"
                                    class="flex w-14 flex-col items-center"
                                >
                                    <div class="relative">
                                        <img
                                            src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                                            alt="{{ Auth::user()->name }}"
                                            class="h-10 w-10 rounded-full"
                                        />

                                        <div class="absolute bottom-[3px] right-0 h-2 w-2 rounded-full bg-red-600">
                                        </div>
                                    </div>

                                    <span class="text-sm text-slate-600 line-clamp-2">
                                        Minh la moi nguoi dep
                                    </span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex items-center gap-2 bg-slate-100 py-4 px-2">
                    <div class="relative">
                        <img
                            src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                            alt="{{ Auth::user()->name }}"
                            class="h-12 w-12 rounded-full"
                        />

                        <div class="absolute bottom-1 right-0 h-2 w-2 rounded-full bg-red-600"></div>
                    </div>

                    <div>
                        <p class="font-semibold text-slate-800">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="text-slate-600">
                            {{ Auth::user()->phone_number }}
                        </p>
                    </div>
                </div>

                <ul class="mt-6 flex-1 p-2">
                    <li>
                        <span class="rounded-full bg-slate-200 py-2 px-3 text-slate-800">
                            Xin chao ban
                        </span>
                    </li>

                    <li class="mt-6 flex justify-end">
                        <span class="rounded-full bg-primary-400 py-2 px-3 text-slate-100">
                            Ban dang lam gi vay
                        </span>
                    </li>
                </ul>

                <form @submit.prevent="sendMessage">
                    <div class="flex items-center gap-1 border-t border-r border-slate-200 px-3 py-2 shadow">
                        <input
                            x-model.trim="message"
                            type="text"
                            class="flex-1 border-none bg-transparent text-slate-800 focus:ring-transparent"
                            placeholder="{{ __('Type your message here...') }}"
                        />

                        <button>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-6 w-6 text-slate-800"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"
                                />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="mt-36 flex flex-col items-center justify-center">
                <span class="text-slate-600">
                    {{ __('Please login to chat') }}
                </span>

                <a
                    href="{{ route('login') }}"
                    class="text-lg font-semibold text-primary-800 underline hover:text-primary-900"
                >
                    {{ __('Login') }}
                </a>
            </div>
        @endif
    </div>

    <button
        type="button"
        class="flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-4 py-3 shadow"
        @click="open = !open"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6 text-slate-800"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"
            />
        </svg>

        <span class="font-semibold text-slate-800">
            {{ __('Chat') }}
        </span>
    </button>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('chat', () => ({
                open: true,
                message: '',

                sendMessage() {
                    console.log(this.message)

                    this.message = ''
                },

                isOverflown(element) {
                    return element.scrollHeight > element.clientHeight || element.scrollWidth > element
                        .clientWidth;
                },
            }))
        })
    </script>
</div>
