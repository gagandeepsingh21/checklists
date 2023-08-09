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
    public $faultchecked;
    public $resolution;
    public function __construct(Checklist $checklist,Resolution $resolution,FaultChecked $faultchecked, $link)
    {
        $this->Checklist = $checklist;
        $this->Resolution = $resolution;
        $this->FaultChecked = $faultchecked;
        $this->link = $link;
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
            $faults = Faults::find($this->FaultChecked->fault_id)->first();
            $classes = Classes::find($this->Checklist->class_id);
            $buildings = $classes->building;
        return new Content(
            markdown: 'emails.checklist.created',
            with: [
                'building_name' =>  $buildings->building_name,
                'class_name' => $classes->class_name,
                'faults_identified'=> $faults->faults_identified,                
                'message' => $this->FaultChecked->message,
                'status' => $this->Resolution->status,
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
