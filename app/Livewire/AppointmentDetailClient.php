<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\AppointmentFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AppointmentDetailClient extends Component
{
    public $appointment;
    public $uploadedFiles = [];

    public function mount($id)
    {
        $this->appointment = Appointment::with(['animal.medicalHistories.specialist', 'user', 'service'])->findOrFail($id);
        $this->loadUploadedFiles();
        if($this->appointment->animal->proprietaire->latitude == null && $this->appointment->animal->proprietaire->longitude == null){
            $this->appointment->animal->proprietaire->updateCoordinatesFromAddress();
        }
    }

    public function loadUploadedFiles()
    {
        $this->uploadedFiles = AppointmentFile::where('appointment_id', $this->appointment->id)->get();
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
        return view('livewire.appointment-detail-client');
    }
}
