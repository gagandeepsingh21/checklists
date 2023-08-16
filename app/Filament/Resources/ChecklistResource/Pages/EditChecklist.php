<?php

namespace App\Filament\Resources\ChecklistResource\Pages;

use App\Models\Faults;
use App\Models\Buildings;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ChecklistResource;

class EditChecklist extends EditRecord
{
    protected static string $resource = ChecklistResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl():string{
        return $this->getResource()::getUrl('index');
    }
   
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $checklist = $this->record;
        $classes = $checklist->class;
        $buildings = $classes->building->first();   
        // $resolution = $faultsChecked->resolution->first();
        $faults = $checklist->faults;


        $data['building_id'] = $buildings?->id; 

        $classesIds = [];
        foreach ($classes as $class) {
            $classesIds[] = $class->id;
        }
        $data['class_id'] = $classesIds;

        $faultsIds = [];
        foreach ($faults as $fault) {
            $faultsIds[] = $fault->id;
        }
        $data['fault_id'] = $faultsIds; 
        return $data;
    }
    public function afterSave(){
        $fault = Faults::firstWhere('id',$this->data['fault_id']);            
        $this->record->faults()->sync($this->data['fault_id']);
        
    }

}
