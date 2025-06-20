<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class ChatWithProfessionals extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedUser;
    public $messages = [];
    public $message = '';
    public $userConversations = [];
    public $perPage = 5; // Nombre de messages par page
    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $this->userConversations = Message::where(function ($query) {
            $query->where('sender_id', Auth::id())
                ->orWhere('receiver_id', Auth::id());
        })
            ->whereHas('sender', function ($query) {
                $query->where('type', 'S'); // L'expéditeur doit être un professionnel
            })
            ->whereHas('receiver', function ($query) {
                $query->where('type', 'S'); // Le destinataire aussi
            })
            ->latest('created_at') // Trier par date de création
            ->get()
            ->groupBy(fn($message) => $message->sender_id == Auth::id() ? $message->receiver_id : $message->sender_id)
            ->map(fn($messages) => [
                'last_message' => $messages->first(), // Le dernier message de chaque groupe
                'unread_count' => $messages->where('receiver_id', Auth::id())->where('is_read', false)->count(), // Nombre de messages non lus
            ]);
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
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $this->selectedUser->id)
                    ->whereHas('sender', function ($q) {
                        $q->where('type', 'S'); // Vérifie que l'expéditeur est un spécialiste
                    })
                    ->whereHas('receiver', function ($q) {
                        $q->where('type', 'S'); // Vérifie que le destinataire est un spécialiste
                    });
            })
                ->orWhere(function ($query) {
                    $query->where('sender_id', $this->selectedUser->id)
                        ->where('receiver_id', Auth::id())
                        ->whereHas('sender', function ($q) {
                            $q->where('type', 'S'); // Vérifie que l'expéditeur est un spécialiste
                        })
                        ->whereHas('receiver', function ($q) {
                            $q->where('type', 'S'); // Vérifie que le destinataire est un spécialiste
                        });
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

    public function render()
    {
        return view('livewire.chat-with-professionals',[
            'users' => User::where('name', 'like', '%' . $this->search . '%')
                ->where('id', '!=', Auth::id())
                ->where("type",'=','S')
                ->get(),
        ]);
    }
}
