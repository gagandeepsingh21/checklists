<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Mail\Reminder;
use App\Models\Checklist;
use App\Mail\ChecklistMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class mails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $myChecklists = Checklist::where('status','pending')->get();
        $checklists = [];
        $users = [];
        foreach($myChecklists as $checklist){
            $diff = Carbon::parse($checklist->created_at)->diffInDays(now());
            if($diff<=7){
                $users[] = $checklist->user->email;
                $checklists []= $checklist; 
            }
        }
        if($checklists != null){
            //Log::info($checklists);
            foreach (array_unique($users) as $user){
                $ccMails = ['audiovisuals@strathmore.edu'];
            Mail::to($user)
                ->cc($ccMails)
                ->queue(new Reminder($checklists,route('filament.resources.checklists.index')));
            }
        }
    }
}
