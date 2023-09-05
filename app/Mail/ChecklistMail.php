<?php

namespace App\Mail;

use App\Models\Faults;
use App\Models\Classes;
use App\Models\Buildings;
use App\Models\Checklist;
use App\Models\Resolution;
use App\Models\FaultChecked;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChecklistMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $link;

    public $building_id;

    public function __construct(Checklist $checklist, $link, $building_id)
    {
        $this->Checklist = $checklist;
        $this->link = $link;
        $this->building_id = $building_id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Checklist Created Confirmation',
            tags: ['Checklist Creation'],
            metadata: [
            'Checlist Id' => $this->Checklist->id,
        ],

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
            $checklists = $this->Checklist;
            $faults = $checklists->faults;
            $faultsIds = [];
            foreach ($faults as $fault) {
                $faultsIds[] = $fault->faults_identified;
            } 
            $classes = $checklists->class;
            $classesIds = [];
            foreach ($classes as $class) {
                $classesIds[] = $class->class_name;
            }
            $data['class_id'] = $classesIds;
            // $buildings = $classes?->building;
            // dd($buildings);
            $buildings = Buildings::find($this->building_id);
            //Log::info($buildings);
        return new Content(
            markdown: 'emails.checklist.created',
            with: [
                'building_name' =>  $buildings->building_name,
                'class_name' => $classesIds,
                'faults_identified'=> $faultsIds,                
                'message' => $this->Checklist->message,
                'status' => $this->Checklist->status,
                'date_created' => $this->Checklist->date_created,
                'link'=> $this->link,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
