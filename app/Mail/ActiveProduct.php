<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActiveProduct extends Mailable
{
    use Queueable, SerializesModels;

    public $product; // Thông tin sản phẩm

    public $title;   // Tiêu đề email

    public $body;    // Nội dung email

    public function __construct($product, $title, $body)
    {
        $this->product = $product;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Thiết lập tiêu đề email.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: $this->title,
        );
    }

    /**
     * Thiết lập nội dung email.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'email.activeproduct'
        );
    }

    /**
     * Lấy danh sách các file đính kèm nếu có.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
