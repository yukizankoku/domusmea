<?php

namespace App\Filament\Widgets;

use App\Models\Commission;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DealPropertyChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Total Penjualan Rumah';

    protected function getData(): array
    {
        // Mengambil total komisi per bulan
        $deals = Commission::select(
            DB::raw('SUM(deal_price) as total'), //Total Komisi Perusahaan
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
                    'data' => $deals->values(),
                    'borderColor' => 'rgba(226, 217, 60, 0.8)', // Warna garis
                    'backgroundColor' => 'rgba(76, 175, 80, 0.2)', // Warna area
                ],
            ],
            'labels' => $deals->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
