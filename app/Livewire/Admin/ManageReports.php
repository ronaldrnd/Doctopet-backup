<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\UserReport;
use App\Models\UserWarning;
use Livewire\Component;
use Livewire\WithPagination;

class ManageReports extends Component
{
    use WithPagination;

    public function blockUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->is_blocked = true;
        $user->save();
    }

    public function render()
    {
        return view('livewire.admin.manage-reports', [
            'reports' => UserReport::latest()->paginate(10),
            'warnings' => UserWarning::latest()->paginate(10)
        ]);
    }
}
