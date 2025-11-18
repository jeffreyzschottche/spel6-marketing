<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public array $payload
    ) {
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this
            ->subject('Nieuw bericht: ' . $this->payload['subject'])
            ->replyTo($this->payload['email'], $this->payload['name'])
            ->view('emails.contact-message', [
                'name' => $this->payload['name'],
                'email' => $this->payload['email'],
                'subject' => $this->payload['subject'],
                'body' => $this->payload['message'],
            ]);
    }
}
