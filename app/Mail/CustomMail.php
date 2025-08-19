<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    public $recipientEmail;
    public $emailSubject;
    public $emailMessage;
    public $userName;

    /**
     * Create a new message instance.
     */
    public function __construct($to, $subject, $message, $userName = 'UZASHOP Client')
    {
        $this->recipientEmail = $to;
        $this->emailSubject = $subject;
        $this->emailMessage = $message;
        $this->userName = $userName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.custom',
            with: [
                'recipientEmail' => $this->recipientEmail,
                'emailSubject' => $this->emailSubject,
                'emailMessage' => $this->emailMessage,
                'userName' => $this->userName,
            ]
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
