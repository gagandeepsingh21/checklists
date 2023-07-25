<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Reminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $link;

    public $Checklist;
    public function __construct($checklist, $link)
    {
        $this->Checklist = $checklist;
        $this->link = $link;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '  Checklists Pending Reminder',
            tags: ['Checklist Pending'],
        //     metadata: [
        //     'Checlist Id' => $this->Checklist->id,
        // ],

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.checklist',
            with: [
                // 'building_name' => implode(', ', $this->Checklist->building_name),
                // 'class_name' => implode(', ', $this->Checklist->class_name),
                // 'faults_identified'=> implode(', ', $this->Checklist->faults_identified),                
                // 'message' => $this->Checklist->message,
                // 'status' => $this->Checklist->status,
                'date_created' => $this->Checklist,
                // 'link'=> $this->link,
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
