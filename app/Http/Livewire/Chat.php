<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Livewire\Component;

class Chat extends Component
{
    public ?int $selectedRoomId = null;

    public function mount(): void
    {
    }

    public function updateLastVisitedAt(): void
    {
        if (! \Auth::check()) {
            return;
        }

        \Auth::user()->update([
            'last_visited_at' => now(),
        ]);

        $this->skipRender();
    }

    public function updateSelectedRoomId(int $roomId): void
    {
        $this->selectedRoomId = $roomId;
    }

    public function createRoomMessage(string $message): null|int
    {
        if (! $message) {
            return null;
        }

        if (! \Auth::check()) {
            return null;
        }

        $room = ChatRoom::find($this->selectedRoomId);

        if (\Auth::id() !== $room->user1_id && \Auth::id() !== $room->user2_id) {
            return null;
        }

        $message = ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => \Auth::id(),
            'message' => $message,
        ]);

        $room->update([
            'updated_at' => now(),
        ]);

        $this->skipRender();

        return $message->id;
    }

    public function render()
    {
        if (\Auth::check()) {
            $rooms = ChatRoom::where('user1_id', \Auth::id())
                ->orWhere('user2_id', \Auth::id())
                ->with(['user1', 'user2'])
                ->orderBy('updated_at', 'desc')
                ->get()
            ;

            if (! $this->selectedRoomId) {
                $this->selectedRoomId = $rooms->first()?->id;
            }

            if ($this->selectedRoomId) {
                $room = $rooms->firstWhere('id', $this->selectedRoomId);
                $messages = ChatMessage::where('chat_room_id', $room->id)
                    ->orderBy('id')
                    ->limit(50)
                    ->get()
                ;
            }
        }

        return view('livewire.chat', [
            'rooms' => $rooms ?? [],
            'room' => $room ?? null,
            'messages' => $messages ?? [],
        ]);
    }
}
