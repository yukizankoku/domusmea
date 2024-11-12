<?php

namespace App\Filament\Widgets;

use App\Models\Commission;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PropertyChart extends ChartWidget
{

    protected static ?int $sort = 3;

    protected static ?string $heading = 'Company Commission Chart';

    protected function getData(): array
    {
        // Mengambil total komisi per bulan
        $commissions = Commission::select(
            DB::raw('SUM(company_commission) as total'), //Total Komisi Perusahaan
            DB::raw('DATE_FORMAT(properties.sold_at, "%Y-%m") as month')
        )
        ->join('properties', 'commissions.property_id', '=', 'properties.id') // Sesuaikan dengan relasi antara Commission dan Property
        ->whereNotNull('properties.sold_at') // Pastikan sold_at tidak null
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');
        
        return [
            'datasets' => [
                [
                    'label' => 'Total Komisi',
                    'data' => $commissions->values(),
                    'borderColor' => 'rgba(45, 164, 206, 0.8)', // Warna garis
                    'backgroundColor' => 'rgba(76, 175, 80, 0.2)', // Warna area
                ],
            ],
            'labels' => $commissions->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
