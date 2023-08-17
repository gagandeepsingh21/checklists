<?php

namespace App\Filament\Resources\ChecklistResource\Pages;

use App\Models\Faults;
use App\Models\Classes;
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
        //$buildings = $checklist->class->first();   
        // $resolution = $faultsChecked->resolution->first();
        $faults = $checklist->faults;

        $buildings = Buildings::find($checklist?->class)->first();
        $buildingname = $buildings?->building_name;
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
        $class = Classes::firstWhere('id',$this->data['class_id']);
        $mappedData = array_map(function($data){
            return intval($data);
        },$this->data['class_id']);
        //dd($mappedData);
        $this->record->class()->sync($mappedData);
    }

}
