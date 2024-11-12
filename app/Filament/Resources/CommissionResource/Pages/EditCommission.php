<?php

namespace App\Filament\Resources\CommissionResource\Pages;

use App\Filament\EditRedirecttoIndex;
use App\Filament\Resources\CommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommission extends EditRedirecttoIndex
{
    protected static string $resource = CommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
