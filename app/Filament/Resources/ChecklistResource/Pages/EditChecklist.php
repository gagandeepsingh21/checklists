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
        $classes = $checklist;
        $buildings = $classes->class->building->first();
        $faultsChecked = $checklist?->faultschecked->first();
        //dd($faultsChecked);
        if ($faultsChecked) {
            $resolution = $faultsChecked->resolution->first();
            // dd($resolution);
        } else {
            $resolution = null; 
        }
        
        // $resolution = $faultsChecked->resolution->first();
        $faults = $checklist->faults;


        $data['building_id'] = $buildings?->id; 

        $data['class_id'] = $classes->class_id;
        $faultsIds = [];
        foreach ($faults as $fault) {
            $faultsIds[] = $fault->id;
        }
        $data['fault_id'] = $faultsIds;
        $data['message'] = $faultsChecked?->message; 
        $data['resolved_by'] = $resolution?->resolved_by; 
        $data['date_resolved'] = $resolution?->date_resolved; 
        $data['status'] = $resolution?->status; 
        
        return $data;
    }
    public function afterSave(){
            if(! is_null($this->data['fault_id'])){
                $fault = Faults::firstWhere('id',$this->data['fault_id']);
                
                $this->record->faults()->sync($this->data['fault_id']);
                   
                $faultsChecked = $fault->faultschecked()->first();

                $id = $faultsChecked ? $faultsChecked->id : 0;
                $faultsChecked->updateOrCreate(['id'=>$id],[
                    'checklist_id'  => $this->record->id,
                    'message' => $this->data['message'],
                ]);
                if($this->data['status'] === 'Solved'){
                    $faultsChecked=$fault->faultschecked->first();
                    $resolution =$faultsChecked->resolution->first();
                    $id = (is_null($faultsChecked->resolution) ? 0 : $faultsChecked->resolution->first()->id);
                    $resolution->updateOrCreate(['id'=>$id],[
                        'resolved_by' => $this->data['resolved_by'],
                        'status' => "Solved",
                        'date_resolved' =>  $this->data['date_resolved'],
                    ]);
                }else{
                    $faultsChecked=$fault->faultschecked->first();
                    $resolution =$faultsChecked->resolution->first();
                    $id = (is_null($faultsChecked->resolution) ? 0 : $faultsChecked->resolution->first()->id);
                   $resolution->updateOrCreate(['id'=>$id],[
                        'status' => "Pending",
                   ]);
                }
            }
    }

}
