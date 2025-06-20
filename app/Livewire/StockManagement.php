<?php

// app/Livewire/StockManagement.php

namespace App\Livewire;

use App\Models\Actif;
use App\Models\Stock;
use App\Models\LogStock;
use App\Models\Fournisseur;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;



class StockManagement extends Component
{
    public $actifs;
    public $stocks;
    public $newActif = [];
    public $selectedActifId;
    public $newStockAmount;
    public $addAsExpense = true;  // Checkbox cochée par défaut

    public $nomFournisseur, $emailFournisseur, $adresseFournisseur;


    public $logStocks;


    public function mount()
    {
        $this->loadActifs();
        $this->loadStocks();
        $this->loadFournisseurs();
        $this->loadLogStocks(); // Charger l'historique des stocks
    }

    public function loadActifs()
    {
        $this->actifs = Actif::all();
    }

    public function loadStocks()
    {
        $this->stocks = Stock::where('user_id', Auth::id())->with('actif')->get();
    }


    public function loadFournisseurs()
    {
        $this->fournisseurs = Fournisseur::where('user_id', Auth::id())->get();
    }


    public function loadLogStocks()
    {
        $this->logStocks = LogStock::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->with('actif')
            ->get();
    }

    public function addFournisseur()
    {
        $this->validate([
            'nomFournisseur' => 'required|string|max:255',
            'emailFournisseur' => 'required|email|max:255',
            'adresseFournisseur' => 'required|string|max:255',
        ]);

        Fournisseur::create([
            'user_id' => Auth::id(),
            'nom' => $this->nomFournisseur,
            'email_adress' => $this->emailFournisseur,
            'adresse_postal' => $this->adresseFournisseur,
        ]);

        session()->flash('message', 'Fournisseur ajouté avec succès.');
        $this->reset(['nomFournisseur', 'emailFournisseur', 'adresseFournisseur']);
    }

    public function addActif()
    {
        $validatedData = $this->validate([
            'newActif.nom' => 'required|string|max:255',
            'newActif.code_ATC' => 'nullable|string|max:255',
            'newActif.code_CIP' => 'nullable|string|max:255',
            'newActif.type' => 'required|string',
            'newActif.prix' => 'required|numeric',
        ]);

        Actif::create($validatedData['newActif']);

        session()->flash('message', 'Actif ajouté avec succès !');
        $this->reset('newActif');
        $this->loadActifs();
    }

    public function addStock()
    {
        $this->validate([
            'selectedActifId' => 'required|exists:actifs,id',
            'newStockAmount' => 'required|integer|min:1',
        ]);

        $stock = Stock::updateOrCreate(
            ['user_id' => Auth::id(), 'actif_id' => $this->selectedActifId],
            ['stock' => DB::raw("stock + {$this->newStockAmount}")]
        );

        LogStock::create([
            'user_id' => Auth::id(),
            'actif_id' => $this->selectedActifId,
            'action' => 'add',
            'number' => $this->newStockAmount,
            'date' => now(),
            'description' => "Ajout de {$this->newStockAmount} unités de {$stock->actif->nom}",
        ]);

        if ($this->addAsExpense) {
            Expense::create([
                'user_id' => Auth::id(),
                'libelle' => "Achat de {$stock->actif->nom}",
                'depense_price' => $stock->actif->prix * $this->newStockAmount,
                'date' => now(),
            ]);
        }

        session()->flash('message', 'Stock mis à jour avec succès !');
        $this->reset(['newStockAmount', 'selectedActifId']);
        $this->loadStocks();
    }


    public function useStock()
    {
        $this->validate([
            'selectedActifId' => 'required|exists:actifs,id',
            'newStockAmount' => 'required|integer|min:1',
        ]);

        $stock = Stock::where('user_id', Auth::id())
            ->where('actif_id', $this->selectedActifId)
            ->first();

        if ($stock && $stock->stock >= $this->newStockAmount) {
            $stock->decrement('stock', $this->newStockAmount);

            LogStock::create([
                'user_id' => Auth::id(),
                'actif_id' => $this->selectedActifId,
                'action' => 'minus',
                'number' => $this->newStockAmount,
                'date' => now(),
                'description' => "Utilisation de {$this->newStockAmount} unités de {$stock->actif->nom}",
            ]);

            session()->flash('message', 'Stock utilisé avec succès !');
        } else {
            session()->flash('error', 'Stock insuffisant !');
        }

        $this->reset(['newStockAmount', 'selectedActifId']);
        $this->loadStocks();
    }


    public function render()
    {
        return view('livewire.stock-management');
    }
}
