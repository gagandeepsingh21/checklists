<?php

namespace App\Filament\Resources\ChecklistResource\Pages;

use App\Models\Faults;
use App\Models\Department;
use App\Mail\ChecklistMail;
use Filament\Pages\Actions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ChecklistResource;

class CreateChecklist extends CreateRecord
{
    protected static string $resource = ChecklistResource::class;

    public function afterCreate(){
        // $this->record->class()->attach($this->data['class_id']);
        if(! is_null($this->data['fault_id'])){
            $fault = Faults::firstWhere('id',$this->data['fault_id']);
            
            $this->record->faults()->sync($this->data['fault_id']);

            
            $faultsChecked = $fault->faultschecked()->create([
                'checklist_id'  => $this->record->id,
                'message' => $this->data['message'],
            ]);
            if($this->data['status'] === 'Solved'){
                $faultsChecked->resolution()->create([
                    'resolved_by' => $this->data['resolved_by'],
                    'status' => "Solved",
                    'date_resolved' =>  $this->data['date_resolved'],
                ]);
            }else{
               $faultsChecked->resolution()->create([
                    'status' => "Pending",
               ]);
            }
        }
    }

    protected function getCreatedNotification(): ?Notification
    { 
        $ccMails = ['audiovisuals@strathmore.edu'];
        $checklist = $this->record;
        

        $faultsChecked = $checklist->faultschecked->first(); 
        
        if ($faultsChecked) {
            $resolution = $faultsChecked->resolution->first();
            //dd($resolution);
            Mail::to(Auth::user()->email)
                ->cc($ccMails)
                ->send(new ChecklistMail($this->record, $resolution, $faultsChecked, route('filament.resources.checklists.index')));
            }
    
        return parent::getCreatedNotification();
    }
    
    protected function getRedirectUrl():string{
        return $this->getResource()::getUrl('index');
    }

}
