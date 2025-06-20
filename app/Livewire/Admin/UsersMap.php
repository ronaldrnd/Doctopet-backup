<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UsersMap extends Component
{
    public $usersWithCoordinates;


    public function mount()
    {
        $this->usersWithCoordinates = User::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'name', 'latitude', 'longitude']);
    }

    public function render()
    {
        return view('livewire.admin.users-map');
    }
}
