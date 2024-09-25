<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class InActiveProduct extends Mailable
{
    public $product;

    public $title;

    public $body;

    /**
     * Tạo một instance mới của email.
     */
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
            view: 'email.inactiveproduct',
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
