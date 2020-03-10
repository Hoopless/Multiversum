<?php

require 'model/Mailable.php';

class MailableController
{
    public function __construct()
    {
        $this->mailable = new Mailable();
    }

    public function sendEmail()
    {
        header('Content-Type: application/json');

        $data = $_POST;
        return $this->mailable->sendMail($data);
    }
}
