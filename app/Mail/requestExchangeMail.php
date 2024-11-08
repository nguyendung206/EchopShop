<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestExchangeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $product;

    public $exchangeProduct;

    public $title;

    public $body;

    public function __construct($product, $exchangeProduct, $title, $body)
    {
        $this->product = $product;
        $this->exchangeProduct = $exchangeProduct;
        $this->title = $title;
        $this->body = $body;
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
            view: 'email.request_exchange'
        );
    }

    public function attachments()
    {
        return [];
    }
}
