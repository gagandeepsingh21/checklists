<?php

namespace App\Filament\Resources\FaultsResource\Pages;

use App\Filament\Resources\FaultsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFaults extends CreateRecord
{
    protected static string $resource = FaultsResource::class;
    protected function getRedirectUrl():string{
        return $this->getResource()::getUrl('index');
    }
}
