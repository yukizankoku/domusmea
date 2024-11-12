<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use Filament\Actions;
use App\Exports\PropertiesExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PropertyResource;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export')
                ->label('Export to Excel')
                ->action(function () {
                    return Excel::download(new PropertiesExport, 'Property List.xlsx');
                })
                ->color('success'),
        ];
    }
}
