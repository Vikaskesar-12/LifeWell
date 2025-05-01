<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $otp;
    public function __construct($otp)
    {

        $this->otp = $otp;
    }
    /**
     * Get the message envelope.
     */
    public function build()
    {
        \Log::info('Data received in forget mail :', ['data' => $this->otp]);
        return $this->view('emails.forget-password')
                    ->subject('Select.mu Acount -' . $this->otp . ' is your verification code for secure access')
                    ->with(['otp' => $this->otp]);
    }
}
