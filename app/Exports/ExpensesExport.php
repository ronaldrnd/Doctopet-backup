<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExpensesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Expense::where('user_id', Auth::id())
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Libellé',
            'Montant (€)'
        ];
    }

    public function map($expense): array
    {
        return [
            $expense->date,
            $expense->libelle,
            number_format($expense->depense_price, 2)
        ];
    }
}
