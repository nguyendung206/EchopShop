<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\ForgotPasswordMail;

class SendForgotPasswordMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;

    protected $token;

    protected $pin;

    protected $email;

    public function __construct($user, $token, $pin, $email)
    {
        $this->user = $user;
        $this->token = $token;
        $this->pin = $pin;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new ForgotPasswordMail($this->user, $this->token, $this->pin);
        Mail::to($this->email)->send($email);
    }
}
