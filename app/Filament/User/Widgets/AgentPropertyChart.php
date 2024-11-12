<?php

namespace App\Filament\User\Widgets;

use App\Models\Commission;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AgentPropertyChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Total Komisi';

    public static function canView(): bool
    {
        return Auth::user()->role !== 'user'; // Ganti 'user' dengan peran yang sesuai
    }

    protected function getData(): array
    {
        $userId = Auth::id(); // Ambil ID user yang sedang login

        // Mengambil total komisi per bulan
        $commissions = Commission::select(
            DB::raw('SUM(CASE 
                WHEN properties.posted_by = ' . $userId . ' THEN listing_commission 
                ELSE 0 
            END) + SUM(CASE 
                WHEN properties.sold_by = ' . $userId . ' THEN selling_commission 
                ELSE 0 
            END) as total'), // Total komisi
            DB::raw('DATE_FORMAT(properties.sold_at, "%Y-%m") as month') // Format bulan
        )
        ->join('properties', 'commissions.property_id', '=', 'properties.id') // Relasi ke properti
        ->whereNotNull('properties.sold_at') // Pastikan sold_at tidak null
        ->groupBy('month')
        ->orderBy(DB::raw('DATE_FORMAT(properties.sold_at, "%Y-%m")')) // Urutkan berdasarkan bulan
        ->pluck('total', 'month'); // Ambil total dan bulan sebagai key-value

        return [
            'datasets' => [
                [
                    'label' => 'Total Komisi',
                    'data' => $commissions->values(),
                    'borderColor' => 'rgba(45, 164, 206, 0.8)', // Warna garis
                    'backgroundColor' => 'rgba(76, 175, 80, 0.2)', // Warna area
                ],
            ],
            'labels' => $commissions->keys(), // Label diambil dari key bulan
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
