<?php

namespace App\Livewire\Admin;

use App\Models\AdminLog;
use App\Models\Log;
use Livewire\Component;
use Livewire\WithPagination;

class AdminLogs extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.admin-logs', [
            'logs' => Log::latest()->paginate(10)
        ]);
    }
}
