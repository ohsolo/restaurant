<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RiderResetPasswordLinkMail extends Mailable
{
    use Queueable, SerializesModels;
    public $rider;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rider)
    {
        $this->rider = $rider;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('credentials.admin_email_address'))
        ->subject("Reset your app password")
        ->view("emails.rider-reset-password");
    }
}
