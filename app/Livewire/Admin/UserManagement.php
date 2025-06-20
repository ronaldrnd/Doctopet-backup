<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserManagement extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::with(['animaux', 'appointments'])->get();
    }

    public function toggleVerification($userId)
    {
        $user = User::find($userId);
        $user->is_verified = !$user->is_verified;
        $user->save();
    }

    public function toggleBlock($userId)
    {
        $user = User::find($userId);
        $user->is_blocked = !$user->is_blocked;
        $user->save();
    }

    public function chrootUser($id)
    {
        $user = User::find($id);
        Auth::login($user);
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.admin.user-management');
    }
}
