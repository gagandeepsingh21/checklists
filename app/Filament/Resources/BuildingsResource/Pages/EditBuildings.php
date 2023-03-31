<?php

namespace App\Filament\Resources\BuildingsResource\Pages;

use App\Filament\Resources\BuildingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBuildings extends EditRecord
{
    protected static string $resource = BuildingsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl():string{
        return $this->getResource()::getUrl('index');
    }
}
