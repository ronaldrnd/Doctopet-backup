<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\AppointmentFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientFiles extends Component
{
    public $files = [];

    public function mount()
    {
        $this->loadClientFiles();
    }

    public function loadClientFiles()
    {
        $this->files = AppointmentFile::whereHas('appointment', function ($query) {
            $query->where('user_id', Auth::id()); // Récupère uniquement les fichiers liés aux rendez-vous du client connecté
        })->with('appointment.service', 'appointment.animal')->get();
    }

    public function downloadFile($fileId)
    {
        $file = AppointmentFile::findOrFail($fileId);

        if (Storage::disk('public')->exists($file->file_path)) {
            return response()->download(storage_path("app/public/{$file->file_path}"));
        }

        session()->flash('error', '❌ Fichier introuvable.');
    }

    public function render()
    {
        return view('livewire.client-files');
    }
}
