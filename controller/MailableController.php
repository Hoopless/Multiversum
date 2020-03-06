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
        $data = $_POST;
        $this->mailable->sendMail($data);
    }
}