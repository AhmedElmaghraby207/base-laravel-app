<?php

namespace App\Mail;

use App\Admin;
use App\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $admin;
    protected $token;
    protected $mailFrom;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Admin $admin, $token, $mailFrom)
    {
        $this->admin = $admin;
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
        return $this->view('emails.admin.reset-password')
            ->with([
                'admin' => $this->admin,
                'token' => $this->token,
                'senderName' => $this->mailFrom,
                'logo' => ['width' => 10, 'height' => 10],
            ]);
    }
}
