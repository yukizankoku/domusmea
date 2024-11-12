<?php

namespace App\Filament\User\Resources\PropertyListResource\Pages;

use App\Filament\User\Resources\PropertyListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyList extends EditRecord
{
    protected static string $resource = PropertyListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
