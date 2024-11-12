<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserCountWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '5s';

    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Total registered users')
                ->descriptionIcon('heroicon-o-users')
                ->color('info')
                ->chart([
                    7,4,5,8,9,4,2
                ]),
            Stat::make('Total Active Property', Property::where('active', true)->where('sold', false)->count())
                ->description('Total Active Property')
                ->descriptionIcon('heroicon-o-users')
                ->color('danger')
                ->chart([
                    7,4,5,8,9,4,2
                ]),
            Stat::make('Total Sold Property', Property::where('sold', true)->count())
                ->description('Total Sold Property')
                ->descriptionIcon('heroicon-o-users')
                ->color('warning')
                ->chart([
                    7,4,5,8,9,4,2
                ]),
        ];
    }
}
