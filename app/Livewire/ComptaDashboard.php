<?php


namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Expense;
use App\Models\Service;
use App\Models\SpecializedService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Exports\RevenuesExport;
use App\Exports\ExpensesExport;
use Maatwebsite\Excel\Facades\Excel;
class ComptaDashboard extends Component
{
    public $currentBalance;
    public $futureBalance;
    public $expenses = [];
    public $revenues = [];
    public $startDate;
    public $endDate;
    public $totalExpenses;
    public $totalRevenues;

    public $newExpenseLibelle;
    public $newExpensePrice;
    public $newExpenseDate;
    public $totalProfits;

    protected $rules = [
        'newExpenseLibelle' => 'required|string|max:255',
        'newExpensePrice' => 'required|numeric|min:0',
        'newExpenseDate' => 'required|date'
    ];

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->endOfMonth()->toDateString();
        $this->calculateBalances();
        $this->loadExpenses();
        $this->loadRevenues();
    }

    public function calculateBalances()
    {
        $userId = Auth::id();

        // Solde actuel (rendez-vous passés dans la période filtrée)
        $pastAppointments = Appointment::where('assign_specialist_id', $userId)
            ->where('date', '<', Carbon::now()->toDateString())
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status', 'confirmed')
            ->get();

        // Solde futur (rendez-vous futurs dans la période filtrée)
        $futureAppointments = Appointment::where('assign_specialist_id', $userId)
            ->where('date', '>=', Carbon::now()->toDateString())
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status', 'confirmed')
            ->get();


        // TODO

        $this->currentBalance = $this->calculateTotalRevenue($pastAppointments);
        $this->futureBalance = $this->calculateTotalRevenue($futureAppointments);
    }

    public function calculateTotalProfits()
    {
        $userId = Auth::id();

        // Récupérer tous les rendez-vous confirmés depuis le début
        $allAppointments = Appointment::where('assign_specialist_id', $userId)
            ->where('status', 'confirmed')
            ->get();

        $totalRevenue = $this->calculateTotalRevenue($allAppointments);


        // Récupérer toutes les dépenses depuis le début
        $allExpenses = Expense::where('user_id', $userId)->sum('depense_price');

        // Calcul des bénéfices
        $this->totalProfits = $totalRevenue - $allExpenses;
    }


    private function calculateTotalRevenue($appointments)
    {
        $total = 0;
        foreach ($appointments as $appointment) {
            if ($appointment->specialized_service_id) {
                $specializedService = SpecializedService::find($appointment->specialized_service_id);
                $total += $specializedService ? $specializedService->price : 0;
            } else {
                $service = Service::find($appointment->service_id);
                $total += $service ? $service->price : 0;
            }
        }
        return $total;
    }

    public function loadExpenses()
    {
        $userId = Auth::id();
        $this->expenses = Expense::where('user_id', $userId)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->orderBy('date', 'asc')
            ->get();

        $this->totalExpenses = $this->expenses->sum('depense_price');
    }

    public function loadRevenues()
    {
        $userId = Auth::id();
        $appointments = Appointment::where('assign_specialist_id', $userId)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status', 'confirmed')
            ->orderBy('date', 'asc')
            ->get();

        $this->revenues = $appointments->map(function ($appointment) {
            $price = 0;
            if ($appointment->specialized_service_id) {
                $specializedService = SpecializedService::find($appointment->specialized_service_id);
                $price = $specializedService ? $specializedService->price : 0;
            } else {
                $service = Service::find($appointment->service_id);
                $price = $service ? $service->price : 0;
            }
            return [
                'date' => Carbon::parse($appointment->date)->format('Y-m-d'),  // Format ISO
                'price' => $price,
            ];

        });

        $this->totalRevenues = $this->revenues->sum('price');
    }


    public function prepareChartData()
    {
        $allDates = collect($this->revenues->pluck('date'))
            ->merge($this->expenses->pluck('date'))
            ->unique()
            ->sort()
            ->values();

        $this->chartLabels = $allDates->toArray();

        $this->chartRevenues = $allDates->map(function($date) {
            return $this->revenues->firstWhere('date', $date)['price'] ?? null;
        });

        $this->chartExpenses = $allDates->map(function($date) {
            return $this->expenses->firstWhere('date', $date)->depense_price ?? null;
        });
    }


    public function addExpense()
    {
        $this->validate();

        Expense::create([
            'user_id' => Auth::id(),
            'libelle' => $this->newExpenseLibelle,
            'depense_price' => $this->newExpensePrice,
            'date' => $this->newExpenseDate,
        ]);

        $this->reset(['newExpenseLibelle', 'newExpensePrice', 'newExpenseDate']);
        $this->loadExpenses();
    }

    public function exportRevenuesToExcel()
    {
        return Excel::download(new RevenuesExport($this->startDate, $this->endDate), 'revenues.xlsx');
    }

    public function exportExpensesToExcel()
    {
        return Excel::download(new ExpensesExport($this->startDate, $this->endDate), 'expenses.xlsx');
    }

    public function updateDateRange($start, $end)
    {
        $this->startDate = $start;
        $this->endDate = $end;

        $this->loadExpenses();
        $this->loadRevenues();
        $this->calculateBalances();
        $this->calculateTotalProfits();  // Ajout du calcul des bénéfices
        $this->prepareChartData();
    }


    public function render()
    {
        $this->loadExpenses();
        $this->loadRevenues();
        $this->calculateBalances();
        $this->calculateTotalProfits();
        $this->prepareChartData();

        return view('livewire.compta-dashboard', [
            'chartLabels' => $this->chartLabels,
            'chartRevenues' => $this->chartRevenues,
            'chartExpenses' => $this->chartExpenses,
        ]);
    }
}


