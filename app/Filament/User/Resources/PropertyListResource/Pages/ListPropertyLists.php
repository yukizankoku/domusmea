<?php

namespace App\Filament\User\Resources\PropertyListResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\User\Resources\PropertyListResource;
use App\Filament\User\Resources\PropertyListResource\Widgets\PropertyCountWidget;

class ListPropertyLists extends ListRecords
{
    protected static string $resource = PropertyListResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PropertyCountWidget::class
        ];
    }
}
