<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\CreateRedirecttoIndex;
use App\Filament\Resources\PropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Property;

class CreateProperty extends CreateRedirecttoIndex
{
    protected static string $resource = PropertyResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        DB::transaction(function () use (&$data) {
            DB::statement('LOCK TABLES properties WRITE');

            // Hitung kode properti berikutnya
            $lastProperty = Property::latest('id')->first();
            $nextId = $lastProperty ? $lastProperty->id + 1 : 1;
            $data['code'] = sprintf('DM-%06d', $nextId);
        });

        return $data;
    }
}
