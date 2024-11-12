<?php

namespace App\Filament\User\Resources\PropertyResource\Pages;

use App\Filament\CreateRedirecttoIndex;
use App\Filament\User\Resources\PropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProperty extends CreateRedirecttoIndex
{
    protected static string $resource = PropertyResource::class;
}
