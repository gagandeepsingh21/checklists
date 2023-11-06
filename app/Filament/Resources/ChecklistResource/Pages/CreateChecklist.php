<?php

namespace App\Filament\Resources\ChecklistResource\Pages;

use App\Models\Faults;
use App\Models\Classes;
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
            $class = Classes::firstWhere('id',$this->data['class_id']);
            
            $this->record->class()->attach($this->data['class_id']);
            

    }

    protected function getCreatedNotification(): ?Notification
    { 
        $ccMails = ['bogutu@strathmore.edu'
        ,'lsally@strathmore.edu'
        ,'mkihara@strathmore.edu'
        ,'msuka@strathmore.edu'
        ,'bulonza.ntumwa@strathmore.edu'
        ,'mngesa@strathmore.edu'
        ,'john.kibuna@strathmore.edu'];
         
            Mail::to(Auth::user()->email)
                ->cc($ccMails)
                ->send(new ChecklistMail($this->record,$this->data['building_id']));
            
    
        return parent::getCreatedNotification();
    }
    
    protected function getRedirectUrl():string{
        return $this->getResource()::getUrl('index');
    }

}
