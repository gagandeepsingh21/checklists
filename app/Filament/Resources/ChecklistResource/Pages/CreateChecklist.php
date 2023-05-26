<?php

namespace App\Filament\Resources\ChecklistResource\Pages;

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
    protected function getCreatedNotification(): ?Notification
    {   
     
        Mail::to(Auth::user()->email)->send(new ChecklistMail($this->record));
        return parent::getCreatedNotification();
    }

    protected function getRedirectUrl():string{
        return $this->getResource()::getUrl('index');
    }

}
