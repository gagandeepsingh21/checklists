<?php

namespace App\Filament\Resources\ChecklistNoFaultsResource\Pages;

use App\Filament\Resources\ChecklistNoFaultsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChecklistNoFaults extends ListRecords
{
    protected static string $resource = ChecklistNoFaultsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create Checklist'),
        ];
    }
}
