<?php

namespace App\Filament\Resources\BuildingsResource\Pages;

use App\Filament\Resources\BuildingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBuildings extends CreateRecord
{
    protected static string $resource = BuildingsResource::class;
    protected function getRedirectUrl():string{
        return $this->getResource()::getUrl('index');
    }
}
