<?php

namespace App\Exports;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\SpecializedService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class RevenuesExport implements FromCollection, WithHeadings, WithMapping
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
        return Appointment::where('assign_specialist_id', Auth::id())
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status', 'confirmed')
            ->with(['animal', 'user', 'service', 'specializedService'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Heure de début',
            'Heure de fin',
            'Client',
            'Animal',
            'Service',
            'Prix (€)'
        ];
    }

    public function map($appointment): array
    {
        $serviceName = $appointment->specializedService
            ? $appointment->specializedService->name
            : $appointment->service->name;

        $price = $appointment->specializedService
            ? $appointment->specializedService->price
            : $appointment->service->price;

        return [
            $appointment->date,
            $appointment->start_time,
            $appointment->end_time,
            $appointment->user->name,
            $appointment->animal->nom,
            $serviceName,
            number_format($price, 2)
        ];
    }
}
