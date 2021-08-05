<?php

namespace App\Mail;

use App\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $patient;
    protected $token;
    protected $mailFrom;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Patient $patient, $token, $mailFrom)
    {
        $this->patient = $patient;
        $this->token = $token;
        $this->mailFrom = $mailFrom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.patient.reset-password')
            ->with([
                'patient' => $this->patient,
                'token' => $this->token,
                'senderName' => $this->mailFrom,
                'logo' => ['width' => 10, 'height' => 10],
            ]);
    }
}
