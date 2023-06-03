<div
    x-data="chat"
    class="flex flex-col items-end"
>

    @php
        $height = 'h-[460px]';
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
            @if ($room)
                <div class="{{ $height }} flex flex-1 flex-col">

                    <div class="p-2">
                        <ul class="flex items-end gap-2 overflow-auto">
                            @foreach ($rooms as $roomItem)
                                @php
                                    $user = $roomItem->user1_id == Auth::id() ? $roomItem->user2 : $roomItem->user1;
                                @endphp
                                <li>
                                    <button
                                        type="button"
                                        class="flex w-14 flex-col items-center"
                                        @click="updateRoomId({{ $roomItem->id }})"
                                    >
                                        <div class="relative">
                                            <img
                                                src="{{ $user->profile_photo_url }}"
                                                alt="{{ $user->name }}"
                                                class="h-10 w-10 rounded-full"
                                            />

                                            <div @class([
                                                'absolute bottom-[3px] right-0 h-2 w-2 rounded-full' => true,
                                                'bg-green-600' => $user->last_visited_at?->gte(now()->subMinutes(5)),
                                                'bg-red-600' => !$user->last_visited_at?->gte(now()->subMinutes(5)),
                                            ])>
                                            </div>
                                        </div>

                                        <span class="text-sm text-slate-600 line-clamp-2">
                                            {{ $user->name }}
                                        </span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    @php
                        $chatPartner = $room->user1_id == Auth::id() ? $room->user2 : $room->user1;
                    @endphp

                    <div class="flex items-center gap-2 bg-slate-100 py-4 px-2">
                        <div class="relative">
                            <img
                                src="{{ $chatPartner->profile_photo_url }}"
                                alt="{{ $chatPartner->name }}"
                                class="h-12 w-12 rounded-full"
                            />

                            <div @class([
                                'absolute bottom-1 right-0 h-2 w-2 rounded-full' => true,
                                'bg-green-600' => $chatPartner->last_visited_at?->gte(now()->subMinutes(5)),
                                'bg-red-600' => !$chatPartner->last_visited_at?->gte(now()->subMinutes(5)),
                            ])>
                            </div>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-800">
                                {{ $chatPartner->name }}
                            </p>

                            <p class="text-slate-600">
                                {{ $chatPartner->phone_number }}
                            </p>
                        </div>
                    </div>

                    <ul
                        x-ref="messageList"
                        class="mt-6 flex-1 space-y-5 overflow-auto p-2"
                    >

                        @foreach ($messages as $message)
                            @if ($message->user_id == Auth::id())
                                <li class="flex justify-end">
                                    <span class="rounded-full bg-primary-400 py-2 px-3 text-slate-100">
                                        {{ $message->message }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    <span class="rounded-full bg-slate-200 py-2 px-3 text-slate-800">
                                        {{ $message->message }}
                                    </span>
                                </li>
                            @endif
                        @endforeach

                        <template x-for="message in newMessages">
                            <li :class="{ 'flex justify-end': message.user_id == {{ Auth::id() }} }">
                                <span
                                    class="rounded-full py-2 px-3"
                                    :class="{
                                        'bg-slate-200 text-slate-800': message.user_id != {{ Auth::id() }},
                                        'bg-primary-400 text-slate-100': message.user_id == {{ Auth::id() }},
                                    }"
                                    x-text="message.message"
                                ></span>
                            </li>
                        </template>
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
                    <span class="px-8 text-center text-slate-600">
                        {{ __('You have no chat history, please click to "Chat with hosteller" in hostel detail page.') }}
                    </span>
                </div>
            @endif
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
        class="relative flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-4 py-3 shadow"
        @click="openChat"
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

        <div
            x-show="newMessageShouldRead"
            x-cloak
            class="absolute -top-1 right-0 h-3 w-3 rounded-full bg-red-500"
        >

        </div>
    </button>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('chat', () => ({
                open: false,
                message: '',
                justCreatedMessage: false,
                newMessageShouldRead: false,
                newMessages: [],

                init() {
                    this.updateLastVisitedAt();
                    console.log(this.$wire.rooms)
                    setInterval(() => {
                        this.updateLastVisitedAt();
                    }, 1000 * 60 * 2)

                    this.handleEchoMessages();
                    this.handleEchoChatRooms();

                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                },

                updateLastVisitedAt() {
                    this.$wire.updateLastVisitedAt()
                },

                handleEchoMessages() {
                    const userId = this.$wire.userId;

                    if (!userId) return;

                    window.Echo.private(`App.Models.User.${userId}`)
                        .listen('ChatMessageCreated', (e) => {
                            if (!this.open) {
                                this.newMessageShouldRead = true;
                            }

                            const chatMessage = e.chatMessage;
                            if (
                                chatMessage.user_id != {{ \Auth::id() ?? 0 }} &&
                                chatMessage.chat_room_id == this.$wire.selectedRoomId
                            ) {

                                this.newMessages.push(chatMessage);
                                this.$nextTick(() => {
                                    this.scrollToBottom();
                                });
                            }
                        });
                },

                handleEchoChatRooms() {
                    const userId = this.$wire.userId;

                    if (!userId) return;

                    window.Echo.private(`App.Models.User.${userId}`)
                        .listen('ChatRoomCreated', (e) => {
                            this.updateRoomId(e.chatRoom.id);
                        });
                },

                async updateRoomId(roomId) {
                    this.newMessages = [];
                    await this.$wire.updateSelectedRoomId(roomId)
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                },

                scrollToBottom() {
                    const messageList = this.$refs.messageList;
                    if (messageList) {
                        messageList.scrollTop = messageList.scrollHeight;
                    }
                },

                openChat() {
                    this.open = !this.open;
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });

                    this.newMessageShouldRead = false;
                },

                sendMessage() {
                    this.newMessages.push({
                        message: this.message,
                        user_id: {{ \Auth::id() ?? 0 }},
                    });

                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });

                    this.$wire.createRoomMessage(this.message)

                    this.message = ''
                },
            }))
        })
    </script>
</div>
