<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export')
                ->label('Export to Excel')
                ->action(function () {
                    return Excel::download(new UserExport, 'User List.xlsx');
                })
                ->color('success'),
        ];
    }
}
