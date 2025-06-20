<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class ActivateAccount extends Component
{
    public $token;
    public $user;
    public $password;
    public $password_confirmation;
    public $address;

    public function mount($token)
    {
        $this->user = User::with('animaux')->where('activation_token', $token)->firstOrFail();
    }

    public function submit()
    {
        $this->validate([
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string|max:255',
        ]);


        $this->user->update([
            'password' => Hash::make($this->password),
            'address' => $this->address,
            'is_active' => 1,
            'activation_token' => null,
        ]);

        $this->user->updateCoordinatesFromAddress();

        session()->flash('message', '✅ Votre compte a bien été activé. Vous pouvez maintenant vous connecter.');

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.activate-account');
    }
}
