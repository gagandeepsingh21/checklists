<?php

namespace App\Filament\Resources\ChecklistResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ChecklistResource;
use App\Filament\Resources\ChecklistResource\Widgets\StatisticsOverview;

class ListChecklists extends ListRecords
{
    protected static string $resource = ChecklistResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create Checklist With Faults'),
            Actions\Action::make('Create Checklist Without Faults')->url(route('filament.resources.checklist-no-faults.create'))
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            StatisticsOverview::class,
        ];
    }
}
