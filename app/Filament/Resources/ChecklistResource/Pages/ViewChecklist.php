<?php

namespace App\Filament\Resources\ChecklistResource\Pages;

use App\Filament\Resources\ChecklistResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewChecklist extends ViewRecord
{
    protected static string $resource = ChecklistResource::class;
    protected function getActions(): array
    {
        $checklist = $this->record;
        return [
            Actions\EditAction::make()->url(function() use($checklist){
                if($checklist->faults()->exists()){
                    return route('filament.resources.checklists.edit',$checklist);
                }else{
                    return route('filament.resources.checklist-no-faults.edit',$checklist);
                }
            })
        ];
    }
}
