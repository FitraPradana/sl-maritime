<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PhisingEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData, $subject)
    {
        $this->mailData = $mailData;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.getphising',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [Attachment::fromData(fn () => $this->mailData['pdf']->output(), 'Report.pdf')
        ->withMime('application/pdf'),];
    }
}
