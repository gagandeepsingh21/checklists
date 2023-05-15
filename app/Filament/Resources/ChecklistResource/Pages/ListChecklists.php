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
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            StatisticsOverview::class,
        ];
    }
}
