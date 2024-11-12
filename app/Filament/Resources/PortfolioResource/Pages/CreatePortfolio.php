<?php

namespace App\Filament\Resources\PortfolioResource\Pages;

use Filament\Actions;
use App\Filament\CreateRedirecttoIndex;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PortfolioResource;

class CreatePortfolio extends CreateRedirecttoIndex
{
    protected static string $resource = PortfolioResource::class;
}
