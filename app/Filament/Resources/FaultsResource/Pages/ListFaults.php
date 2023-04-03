<?php

namespace App\Filament\Resources\FaultsResource\Pages;

use App\Filament\Resources\FaultsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFaults extends ListRecords
{
    protected static string $resource = FaultsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
