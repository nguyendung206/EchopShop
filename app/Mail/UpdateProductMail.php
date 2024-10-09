<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UpdateProductMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $product;

    public $title;

    public $body;

    public $type;

    public function __construct($product, $title, $body, $type)
    {
        $this->product = $product;
        $this->title = $title;
        $this->body = $body;
        $this->type = $type;
    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->title
        );
    }

    public function content()
    {
        return new Content(
            view: 'email.wait'
        );
    }

    public function attachments()
    {
        return [];
    }
}
