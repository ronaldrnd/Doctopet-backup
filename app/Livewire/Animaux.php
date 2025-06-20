<?php
namespace App\Livewire;

use App\Models\Animal;
use App\Models\Espece;
use App\Models\Race;
use Livewire\Component;

class Animaux extends Component
{
    public $animaux;
    public $nom, $selectedEspece, $selectedRace, $date_naissance, $historique_medical, $poids, $taille;
    public $races = [];
    public $especes;

    public function mount()
    {
        $this->animaux = auth()->user()->animaux()->with('dossiers')->get();
        $this->especes = Espece::all();
    }

    public function updateRaces($especeId)
    {
        $this->races = Race::where('espece_id', $especeId)->get();
    }

    public function saveAnimal()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'poids' => 'required|numeric|min:1',
            'taille' => 'required||numeric|min:0',
            'selectedEspece' => 'required|exists:especes,id',
            'selectedRace' => 'required|exists:races,id',
            'date_naissance' => 'required|date',
            'historique_medical' => 'nullable|string',
        ]);

        auth()->user()->animaux()->create([
            'nom' => $this->nom,
            'poids' => $this->poids,
            'taille' => $this->taille,
            'espece_id' => $this->selectedEspece,
            'race_id' => $this->selectedRace,
            'date_naissance' => $this->date_naissance,
            'historique_medical' => $this->historique_medical ?? "",

        ]);

        $this->reset(['nom', 'poids', 'taille', 'selectedEspece', 'selectedRace', 'date_naissance', 'historique_medical', 'races']);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.animaux', [
            'animaux' => $this->animaux,
            'especes' => $this->especes,
            'races' => $this->races,
        ]);
    }
}
