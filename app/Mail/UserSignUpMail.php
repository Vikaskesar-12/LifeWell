<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserSignUpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $otp;
    public $name;
    public function __construct($otp,$name)
    {
        $this->otp = $otp;
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        \Log::info('Data received in forget mail :', ['data' => $this->otp]);
        return $this->view('emails.user-register')
                    ->subject('Select.mu Acount - ' . $this->otp . ' is your verification code for secure access')
                    ->with(['otp' => $this->otp, 'name' => $this->name]);
    }
}
