<?php

namespace App\Livewire;

use App\Models\TriggerStock;
use Livewire\Component;
use App\Models\Actif;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Auth;

class StockTrigger extends Component
{
    public $triggers;
    public $actifs;
    public $fournisseurs;
    public $selectedActif, $selectedFournisseur, $seuil, $isEnable = true, $triggerMethod = 'manual';
    public $default_montant;
    public $editMode = false;
    public $editingTriggerId;

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->triggers = TriggerStock::where('user_id', Auth::id())->get();
        $this->actifs = Actif::all();
        $this->fournisseurs = Fournisseur::all();
    }

    public function saveTrigger()
    {
        $this->validate([
            'selectedActif' => 'required',
            'selectedFournisseur' => 'required',
            'seuil' => 'required|integer|min:1',
            'triggerMethod' => 'required|in:manual,automatic',
            'default_montant' => 'required|integer|min:1',
        ]);


        if ($this->editMode) {
            $trigger = TriggerStock::find($this->editingTriggerId);
            $trigger->update([
                'actif_id' => $this->selectedActif,
                'fournisseur_id' => $this->selectedFournisseur,
                'montant' => $this->seuil,
                'ask_montant' => $this->default_montant,
                'is_enable' => $this->isEnable,
                'trigger_method' => $this->triggerMethod,
            ]);

            session()->flash('message', '✅ Seuil de stock mis à jour avec succès.');
        } else {
            TriggerStock::create([
                'user_id' => Auth::id(),
                'actif_id' => $this->selectedActif,
                'fournisseur_id' => $this->selectedFournisseur,
                'montant' => $this->seuil,
                'ask_montant' => $this->default_montant,
                'is_enable' => $this->isEnable,
                'trigger_method' => $this->triggerMethod === 'automatic'
            ]);

            session()->flash('message', '⚙️ Règle de stock ajoutée avec succès.');
        }

        $this->resetForm();
        $this->refreshData();
    }

    public function edit($triggerId)
    {
        $trigger = TriggerStock::find($triggerId);

        if ($trigger) {
            $this->editingTriggerId = $trigger->id;
            $this->selectedActif = $trigger->actif_id;
            $this->selectedFournisseur = $trigger->fournisseur_id;
            $this->seuil = $trigger->montant;
            $this->default_montant = $trigger->ask_montant;
            $this->isEnable = $trigger->is_enable;
            $this->triggerMethod = $trigger->trigger_method;
            $this->editMode = true;
        }
    }

    public function delete($triggerId)
    {
        $trigger = TriggerStock::find($triggerId);
        if ($trigger) {
            $trigger->delete();
            session()->flash('message', '🗑️ Seuil de stock supprimé avec succès.');
            $this->refreshData();
        }
    }

    public function resetForm()
    {
        $this->selectedActif = '';
        $this->selectedFournisseur = '';
        $this->seuil = '';
        $this->default_montant = '';
        $this->triggerMethod = 'manual';
        $this->isEnable = true;
        $this->editMode = false;
        $this->editingTriggerId = null;
    }

    public function render()
    {
        return view('livewire.stock-trigger');
    }
}
