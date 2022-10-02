<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;

class Mail extends PHPMailer
{

    public function __construct()
    {
        parent::__construct();
        $this->SMTPDebug = 0;
        $this->isSMTP();


        $this->Host = "mail.kartcim.com";
        $this->SMTPAuth = true;
        $this->Username = "hesap@kartcim.com";
        $this->Password = "l8_2yT=AF2:Yn1@d";
        $this->SMTPSecure = false;
        $this->Port = 587;


    }

    public function sendMail($sendMail, $userName, $subject, $body)
    {
        $this->setFrom("hesap@kartcim.com", $subject);
        $this->addAddress($sendMail, $userName);
        $this->isHTML(true);

        $this->Subject = $subject;
        $this->Body = $body;
        return $this->send();
    }

    // $this->mailer = new PHPMailer(true);
}
