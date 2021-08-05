<?php

namespace App\Mail;

use App\Announcement;
use App\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientAnnouncement extends Mailable
{
    use Queueable, SerializesModels;

    protected $announcement;
    protected $patient;
    protected $token;
    protected $mailFrom;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Announcement $announcement, Patient $patient, $token, $mailFrom)
    {
        $this->announcement = $announcement;
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
        return $this->view('emails.patient.announcement')
            ->with([
                'announcement' => $this->announcement,
                'patient' => $this->patient,
                'token' => $this->token,
                'senderName' => $this->mailFrom,
                'logo' => ['width' => 10, 'height' => 10],
            ]);
    }
}
