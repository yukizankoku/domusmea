<?php

namespace App\Filament\User\Resources\PropertyListResource\Widgets;

use App\Models\Property;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class PropertyCountWidget extends BaseWidget
{
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    protected function getStats(): array
    {
        return [
            Stat::make('Total Active Property', Property::where('active', true)->where('sold', false)->count())
                ->description('Total Active Property')
                ->descriptionIcon('heroicon-o-users')
                ->color('danger')
                ->chart([
                    7,4,5,8,9,4,2
                ]),
            Stat::make('Total Sold Property', Property::where('sold', true)->where('sold_by', Auth::id())->count())
                ->description('Total Sold Property')
                ->descriptionIcon('heroicon-o-users')
                ->color('warning')
                ->chart([
                    7,4,5,8,9,4,2
                ]),
        ];
    }
}
