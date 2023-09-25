<?php

namespace App\Filament\Resources\ChecklistNoFaultsResource\Pages;

use App\Models\Faults;
use App\Models\Classes;
use App\Mail\ChecklistMail;
use Filament\Pages\Actions;
use App\Mail\ChecklistNoFault;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ChecklistNoFaultsResource;

class CreateChecklistNoFaults extends CreateRecord
{
    protected static string $resource = ChecklistNoFaultsResource::class;

    protected static ?string $title = 'Create Checklist With no Faults';

    public function afterCreate(){
        // $this->record->class()->attach($this->data['class_id']);
            // $fault = Faults::firstWhere('id',$this->data['fault_id']);
            
            // $this->record->faults()->attach($this->data['fault_id']);
            $class = Classes::firstWhere('id',$this->data['class_id']);
            
            $this->record->class()->attach($this->data['class_id']);
            

    }

    protected function getCreatedNotification(): ?Notification
    { 
        $ccMails = ['audiovisuals@strathmore.edu'];
 
            Mail::to(Auth::user()->email)
                ->cc($ccMails)
                ->send(new ChecklistNoFault($this->record));
            
    
        return parent::getCreatedNotification();
    }
    protected function getRedirectUrl():string{
        return route('filament.resources.checklists.index');    }
}
