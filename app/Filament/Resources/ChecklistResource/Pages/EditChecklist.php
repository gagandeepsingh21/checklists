<?php

namespace App\Filament\Resources\ChecklistResource\Pages;

use App\Models\Faults;
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
    public function beforeSave(){
        if(! is_null($this->data['fault_id'])){
            $fault = Faults::firstWhere('id',$this->data['fault_id']);
            $faultsChecked = $fault->faultschecked()->create([
                'checklist_id'  => $this->record->id,
                'message' => $this->data['message'],
            ]);
            if($this->data['status'] === 'Solved'){
                $faultsChecked->resolution()->create([
                    'user_id' => $this->data['user_id'],
                    'status' => "solved",
                    'date_resolved' =>  $this->data['date_resolved'],
                ]);
            }else{
               $faultsChecked->resolution()->create([
                    'status' => "Pending",
               ]);
            }
        }
    }

}
