<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedUser;
    public $messages = [];
    public $message = '';
    public $userConversations = [];
    public $perPage = 5; // Nombre de messages par page
    public $perPageConversations = 5; // Nombre de conversations affichées

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $this->userConversations = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->latest('created_at')
            ->get()
            ->groupBy(fn($message) => $message->sender_id == Auth::id() ? $message->receiver_id : $message->sender_id)
            ->map(fn($messages) => [
                'last_message' => $messages->first(),
                'unread_count' => $messages->where('receiver_id', Auth::id())->where('is_read', false)->count(),
            ])
            ->take($this->perPageConversations); // Ajout de la pagination
    }



    public function lastMessageRead()
    {
        if (!$this->selectedUser) {
            return false;
        }

        $lastMessage = Message::where('sender_id', Auth::id())
            ->where('receiver_id', $this->selectedUser->id)
            ->latest('created_at')
            ->first();

        return $lastMessage && $lastMessage->is_read ? $this->selectedUser->name . " a vu votre message" : null;
    }



    public function loadMoreConversations()
    {
        $this->perPageConversations += 5; // Charge 5 conversations supplémentaires
        $this->loadConversations();
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->loadMessages(); // Charger les messages de cette conversation
    }



    public function loadMessages()
    {
        if ($this->selectedUser instanceof \App\Models\User) {
            $this->messages = Message::where(function ($query) {
                $query->where('sender_id', Auth::id())->where('receiver_id', $this->selectedUser->id);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->selectedUser->id)->where('receiver_id', Auth::id());
            })
                ->latest('created_at')
                ->take($this->perPage) // Limiter au nombre de messages spécifié
                ->get();

            // Marquer les messages comme lus
            Message::where('receiver_id', Auth::id())
                ->where('sender_id', $this->selectedUser->id)
                ->update(['is_read' => true]);
        }
    }



    public function loadMore()
    {
        $this->perPage += 5; // Charger 5 messages supplémentaires
        $this->loadMessages(); // Recharger les messages
    }

    public function sendMessage()
    {
        if (!empty($this->message) && $this->selectedUser) {
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $this->selectedUser->id,
                'content' => $this->message,
                'is_read' => false,
            ]);

            $this->message = '';
            $this->loadMessages();
            $this->loadConversations();
        }
    }

    public function render()
    {
        return view('livewire.chat-component', [
            'users' => User::where('name', 'like', '%' . $this->search . '%')
                ->where('id', '!=', Auth::id())
                ->get(),
        ]);
    }
}
