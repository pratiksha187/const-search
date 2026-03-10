<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployerWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employer;
    public $plainPassword;
    public $loginUrl;

    public function __construct($employer, $plainPassword, $loginUrl)
    {
        $this->employer = $employer;
        $this->plainPassword = $plainPassword;
        $this->loginUrl = $loginUrl;
    }

    public function build()
    {
        return $this->subject('Welcome to ConstructKaro client Panel')
            ->view('emails.employer_welcome');
    }
}