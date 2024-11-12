<?php

namespace App\Filament\Resources\TestimonyResource\Pages;

use App\Filament\CreateRedirecttoIndex;
use App\Filament\Resources\TestimonyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTestimony extends CreateRedirecttoIndex
{
    protected static string $resource = TestimonyResource::class;
}
