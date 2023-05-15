<?php

namespace App\Filament\Resources\BuildingsResource\Pages;

use App\Filament\Resources\BuildingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBuildings extends ListRecords
{
    protected static string $resource = BuildingsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
