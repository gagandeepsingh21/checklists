<?php

namespace App\Mail;

use App\Models\Checklist;
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

    public function __construct(Checklist $checklist, $link)
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
        return new Content(
            markdown: 'emails.checklist.created',
            with: [
                'building_name' => implode(', ', $this->Checklist->building_name),
                'class_name' => implode(', ', $this->Checklist->class_name),
                'faults_identified'=> implode(', ', $this->Checklist->faults_identified),                
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
