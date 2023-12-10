<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestaurantResetPasswordLinkMail extends Mailable
{
    use Queueable, SerializesModels;
    public $rest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rest)
    {
        $this->rest = $rest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('credentials.admin_email_address'))
        ->subject("Reset your Restaurant password")
        ->view("emails.reset-password");
    }
}
