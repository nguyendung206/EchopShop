<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $product;

    public $title;

    public $body;

    public $isActive;

    public function __construct($product, $title, $body, $isActive)
    {
        $this->product = $product;
        $this->title = $title;
        $this->body = $body;
        $this->isActive = $isActive;
    }

    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: $this->title
        );
    }

    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'email.product_status'
        );
    }

    public function attachments()
    {
        return [];
    }
}
