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
            $fault = Faults::firstWhere('id',$this->data['fault_id']);
            
            $this->record->faults()->attach($this->data['fault_id']);
            

    }

    protected function getCreatedNotification(): ?Notification
    { 
        $ccMails = ['audiovisuals@strathmore.edu'];
 
            Mail::to(Auth::user()->email)
                //->cc($ccMails)
                ->send(new ChecklistMail($this->record, route('filament.resources.checklists.index')));
            
    
        return parent::getCreatedNotification();
    }
    
    protected function getRedirectUrl():string{
        return $this->getResource()::getUrl('index');
    }

}
