<?php

namespace App\Filament\Resources\CommissionResource\Pages;

use App\Filament\CreateRedirecttoIndex;
use App\Filament\Resources\CommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCommission extends CreateRedirecttoIndex
{
    protected static string $resource = CommissionResource::class;
}
