<?php

namespace App\Mail;

use App\Models\Buildings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\ChecklistNoFaults;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChecklistNoFault extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $link;

    public function __construct(ChecklistNoFaults $checklist, $link)
    {
        $this->ChecklistNoFaults = $checklist;
        $this->link = $link;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Checklist Created Confirmation',
            tags: ['Checklist Creation'],
            metadata: [
            'Checlist Id' => $this->ChecklistNoFaults->id,
        ],

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
            $checklists = $this->ChecklistNoFaults;
            // $faults = $checklists->faults;
            // $faultsIds = [];
            // foreach ($faults as $fault) {
            //     $faultsIds[] = $fault->faults_identified;
            // } 
            $classes = $checklists->class;
            $classesIds = [];
            foreach ($classes as $class) {
                $classesIds[] = $class->class_name;
            }
            $data['class_id'] = $classesIds;
            // $buildings = $classes?->building;
            // dd($buildings);
            $buildings = Buildings::find($checklists?->class)->first();
        return new Content(
            markdown: 'emails.checklist.ChecklistNoFault',
            with: [
                'building_name' =>  $buildings->building_name,
                'class_name' => $classesIds,
                // 'faults_identified'=> $faultsIds,                
                'message' => $this->ChecklistNoFaults->message,
                'status' => $this->ChecklistNoFaults->status,
                'date_created' => $this->ChecklistNoFaults->date_created,
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
