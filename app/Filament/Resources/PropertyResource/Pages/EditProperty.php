<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\EditRedirecttoIndex;
use App\Filament\Resources\PropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProperty extends EditRedirecttoIndex
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
