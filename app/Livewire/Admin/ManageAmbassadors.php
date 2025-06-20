<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\AmbassadorAccessCode;
use App\Services\AmbassadorService;
use Livewire\Component;

class ManageAmbassadors extends Component
{
    public $search = '';

    public function generateCode()
    {
        AmbassadorService::generateAccessCode();
    }

    public function toggleAmbassador($userId)
    {
        $user = User::findOrFail($userId);
        $user->is_ambassador = !$user->is_ambassador;
        $user->save();
    }

    public function render()
    {
        $professionals = User::where('type', 'S')
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->get();

        return view('livewire.admin.manage-ambassadors', [
            'codes' => AmbassadorAccessCode::latest()->get(),
            'professionals' => $professionals,
        ]);
    }
}
