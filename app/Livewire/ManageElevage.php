<?php

namespace App\Livewire;

use App\Models\Elevage;
use App\Models\Espece;
use App\Models\Race;
use App\Models\AdminMessage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ManageElevage extends Component
{
    public $especeId, $raceId, $age, $taille, $stock;
    public $message, $title;
    public $races = [];

    public function mount()
    {
        $this->races = collect(); // Initialisation vide
    }

    public function updateRaces($especeId)
    {
        $this->races = Race::where('espece_id', $especeId)->get();
    }

    public function addAnimal()
    {
        Elevage::create([
            'espece_id' => $this->especeId,
            'race_id' => $this->raceId,
            'age' => $this->age,
            'taille' => $this->taille,
            'stock' => $this->stock,
            'eleveur_id' => Auth::id()
        ]);
        $this->reset();
    }

    public function decreaseStock($id)
    {
        $elevage = Elevage::findOrFail($id);
        if ($elevage->eleveur_id === Auth::id() && $elevage->stock > 0) {
            $elevage->decrement('stock');
        }
    }

    public function sendMessage()
    {
        AdminMessage::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'message' => $this->message,
        ]);
        session()->flash('success', '📨 Message envoyé aux administrateurs.');
        $this->reset('title', 'message');
    }

    public function render()
    {
        return view('livewire.manage-elevage', [
            'especes' => Espece::all(),
            'elevages' => Elevage::where('eleveur_id', Auth::id())->get()
        ]);
    }
}
