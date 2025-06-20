<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Appointment;
use App\Models\AppointmentFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Mail\MedicalHistoryUpdated;
use App\Models\Stock;
use App\Models\LogStock;

class AppointmentDetail extends Component
{
    use WithFileUploads;

    public $appointment;
    public $files = [];
    public $comment = '';
    public $successMessage = '';
    public $uploadedFiles = [];

    public $medicalHistory = ''; // Pour ajouter une nouvelle entrée d'historique
    public $activeMedicalHistories = []; // Historique existant
    public $selectedActifId; // Pour l'utilisation des actifs/médicaments
    public $actifs;
    public $usedStockAmount; // Quantité utilisée


    protected $rules = [
        'comment' => 'required|string|max:1000',
        'files.*' => 'file|max:10240', // Max file size: 10 MB
    ];

    public function mount($id)
    {
        $this->appointment = Appointment::with(['animal.medicalHistories.specialist', 'user', 'service'])->findOrFail($id);
        $this->loadUploadedFiles();
        $this->comment = $this->appointment->comment;
        $this->activeMedicalHistories = $this->appointment->animal->medicalHistories()->latest()->get();
        // Charger uniquement les actifs disponibles dans le stock de l'utilisateur
        $this->actifs = Stock::where('user_id', Auth::id())
            ->where('stock', '>', 0)
            ->with('actif')
            ->get(); // On garde les informations du stock ET des actifs
    }


    public function loadUploadedFiles()
    {
        $this->uploadedFiles = AppointmentFile::where('appointment_id', $this->appointment->id)->get();
    }

    public function uploadFiles()
    {
        $this->validateOnly('files.*');

        foreach ($this->files as $file) {
            // Récupérer le nom original du fichier et son extension
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            // Nettoyer le nom du fichier (éviter les espaces et caractères spéciaux)
            $formattedName = Str::slug($originalName, '_') . '.' . $extension;

            // Définir le chemin de stockage
            $storagePath = "appointments/{$this->appointment->id}";

            // Vérifier si un fichier avec le même nom existe déjà et l'incrémenter si besoin
            $counter = 1;
            $newFileName = $formattedName;

            while (Storage::disk('public')->exists("$storagePath/$newFileName")) {
                $newFileName = Str::slug($originalName, '_') . "_$counter.$extension";
                $counter++;
            }

            // Stocker le fichier avec le nom formaté
            $filePath = $file->storeAs($storagePath, $newFileName, 'public');

            // Enregistrer en base de données
            AppointmentFile::create([
                'appointment_id' => $this->appointment->id,
                'file_name' => $file->getClientOriginalName(), // Conserver le vrai nom original
                'file_path' => $filePath,
            ]);
        }

        // Message de succès
        $this->successMessage = '📤 Fichiers téléchargés avec succès.';
        $this->files = [];
        $this->loadUploadedFiles(); // Mettre à jour la liste des fichiers
    }


    public function addMedicalHistory()
    {
        $this->validate([
            'medicalHistory' => 'required|string|max:1000',
        ]);

        $modification = "Le " . now()->format('d/m/Y') . ", Dr. " . Auth::user()->name . " a ajouté : " . $this->medicalHistory;

        \App\Models\AnimalMedicalHistory::create([
            'animal_id' => $this->appointment->animal->id,
            'specialist_id' => Auth::id(),
            'modification' => $modification,
        ]);

        // Envoi d'un mail au propriétaire de l'animal
        Mail::to($this->appointment->user->email)->send(new MedicalHistoryUpdated($this->appointment->animal, $modification));

        $this->successMessage = '🩺 Historique médical mis à jour avec succès.';
        $this->medicalHistory = '';
        $this->activeMedicalHistories = $this->appointment->animal->medicalHistories()->latest()->get();
    }


    public function useActif()
    {
        $this->validate([
            'selectedActifId' => 'required|exists:actifs,id',
            'usedStockAmount' => 'required|integer|min:1',
        ]);

        $stock = Stock::where('user_id', Auth::id())->where('actif_id', $this->selectedActifId)->first();

        if ($stock && $stock->stock >= $this->usedStockAmount) {
            $stock->decrement('stock', $this->usedStockAmount);

            LogStock::create([
                'user_id' => Auth::id(),
                'actif_id' => $this->selectedActifId,
                'action' => 'minus',
                'number' => $this->usedStockAmount,
                'date' => now(),
                'description' => "Utilisation de {$this->usedStockAmount} unités de {$stock->actif->nom} pour le rendez-vous de {$this->appointment->animal->nom}",
            ]);

            $this->successMessage = '💉 Médicament utilisé et stock mis à jour avec succès !';
        } else {
            $this->successMessage = '❌ Stock insuffisant pour ce médicament.';
        }

        $this->reset(['selectedActifId', 'usedStockAmount']);
    }

    public function downloadFile($fileId)
    {
        $file = AppointmentFile::findOrFail($fileId);

        if (Storage::disk('public')->exists($file->file_path)) {
            return response()->download(storage_path("app/public/{$file->file_path}"));
        }

        session()->flash('error', '❌ Fichier introuvable.');
    }

    public function updateStatus($status)
    {
        if ($this->appointment->status === $status) {
            return;
        }

        $this->appointment->update(['status' => $status]);

        Mail::to($this->appointment->user->email)->send(new \App\Mail\AppointmentStatusUpdated($this->appointment));

        $this->successMessage = "✅ Le rendez-vous a été " . ($status === 'confirmed' ? 'accepté' : 'refusé') . ".";

        $this->appointment = $this->appointment->fresh();
    }

    public function saveComment()
    {
        $this->validateOnly('comment');
        $this->appointment->update(['comment' => $this->comment]);
        $this->appointment->save();
        $this->successMessage = '📝 Commentaire ajouté avec succès.';
    }

    public function deleteFile($fileId)
    {
        $file = AppointmentFile::findOrFail($fileId);

        // Vérifier si le fichier existe avant de le supprimer
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        // Supprimer l'entrée en base de données
        $file->delete();

        // Mettre à jour la liste des fichiers
        $this->loadUploadedFiles();

        // Message de confirmation
        $this->successMessage = "🗑️ Fichier supprimé avec succès.";
    }


    public function render()
    {
        return view('livewire.appointment-detail');
    }
}
