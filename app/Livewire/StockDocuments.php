<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StockDocuments extends Component {
    use WithFileUploads;

    public $files = [];
    public $totalStorageUsed = 0;
    public $maxStorage = 51200; // 50 Mo en Ko (1 Mo = 1024 Ko)

    protected $rules = [
        'files.*' => 'file|max:8192|mimes:pdf,doc,docx,xls,xlsx,jpeg,png', // Max 8 Mo par fichier
    ];

    public function mount() {
        $this->calculateStorageUsed();
    }

    public function calculateStorageUsed() {
        $this->totalStorageUsed = Document::where('user_id', Auth::id())->sum('file_size');
    }

    public function uploadFiles() {
        $this->validate();

        foreach ($this->files as $file) {
            $fileSize = round($file->getSize() / 1024); // Taille en Ko

            if (($this->totalStorageUsed + $fileSize) > $this->maxStorage) {
                session()->flash('error', "Espace de stockage dépassé !");
                return;
            }

            $filePath = $file->store("documents/" . Auth::id(), 'public');

            Document::create([
                'user_id' => Auth::id(),
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_size' => $fileSize,
            ]);

            $this->calculateStorageUsed();
        }

        session()->flash('success', "📤 Documents téléchargés avec succès !");
        $this->files = [];
    }

    public function deleteDocument($documentId) {
        $document = Document::findOrFail($documentId);

        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        $this->calculateStorageUsed();
        session()->flash('success', "🗑️ Document supprimé !");
    }

    public function render() {
        return view('livewire.stock-documents', [
            'documents' => Document::where('user_id', Auth::id())->latest()->get(),
        ]);
    }
}
