<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\CreateRedirecttoIndex;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRedirecttoIndex
{
    protected static string $resource = UserResource::class;
}
