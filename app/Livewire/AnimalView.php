<?php

namespace App\Livewire;

use App\Models\Animal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AnimalView extends Component
{
    use WithFileUploads;

    public $animal;
    public $nom;
    public $espece;
    public $race;
    public $poids;
    public $taille; // Nouveau champ pour la taille
    public $date_naissance;
    public $historique_medical;
    public $photo;
    public $newPhoto;

    public function mount($id)
    {
        $this->animal = Animal::with('espece', 'race', 'dossiers')->findOrFail($id);
        $this->nom = $this->animal->nom;
        $this->espece = $this->animal->espece->nom;
        $this->race = $this->animal->race->nom ?? null;
        $this->date_naissance = $this->animal->date_naissance;
        $this->historique_medical = $this->animal->historique_medical;
        $this->photo = $this->animal->photo;
        $this->poids = $this->animal->poids ?? 0;
        $this->taille = $this->animal->taille ?? null;  // Initialisation de la taille
    }


    public function uploadAndCheckImage($path)
    {
        $response = Http::attach(
            'image', file_get_contents(storage_path("app/public/$path")), 'image.jpg'
        )->post('http://localhost:5000/v1/vision/detection');

        $data = $response->json();
        $validLabels = ['person', 'dog', 'cat', 'horse', 'bird', 'cow', 'sheep', 'elephant', 'bear', 'zebra', 'giraffe'];
        $containsValidObject = false;

        if (!empty($data['predictions'])) {
            foreach ($data['predictions'] as $prediction) {
                if ($prediction['confidence'] >= 0.80 && in_array($prediction['label'], $validLabels)) {
                    $containsValidObject = true;
                    break;
                }
            }
        }
        return $containsValidObject;
    }



    public function updateAnimal()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'historique_medical' => 'nullable|string',
            'newPhoto' => 'nullable|image|max:2048',
            'poids' => 'numeric|min:0',
            'taille' => 'numeric|min:0',
        ]);

        if ($this->newPhoto) {
            $path = $this->newPhoto->store('animal_photos', 'public');

            if (!$this->uploadAndCheckImage($path)) {
                // ❌ Suppression de l'image invalide
                Storage::disk('public')->delete($path);

                // 🔄 Réinitialisation à la photo initiale
                $this->newPhoto = null;

                // 🔔 Message d'erreur
                session()->flash('error', 'La photo ne respecte pas nos critères de validation. Veuillez en choisir une autre.');
                return;
            }

            // ✅ Mise à jour si la photo est valide
            $this->animal->update(['photo' => $path]);
            $this->photo = $path;
        }

        $this->animal->update([
            'nom' => $this->nom,
            'date_naissance' => $this->date_naissance,
            'historique_medical' => $this->historique_medical,
            'poids' => $this->poids,
            'taille' => $this->taille,
        ]);

        session()->flash('success', 'Les informations de l’animal ont été mises à jour avec succès !');
    }

    public function render()
    {
        $dossiers = $this->animal->dossiers->sortByDesc('date');

        return view('livewire.animal-view', [
            'dossiers' => $dossiers,
        ]);
    }
}
