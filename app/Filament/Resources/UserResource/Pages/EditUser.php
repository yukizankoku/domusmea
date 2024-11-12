<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\EditRedirecttoIndex;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRedirecttoIndex
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
