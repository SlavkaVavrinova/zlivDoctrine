<?php

namespace App\Email;

use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;


class EmailService
{

    public function sendReservationEmail($reservation)
    {
        $mail = new Message();
        $headers = [
            'X-Mailer' => 'PHP/' . phpversion(),
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=UTF-8',

        ];
        $mail->setFrom('Chata Růženka <chata.ruzenka@seznam.cz>')
            ->setHeader('X-Mailer', $headers['X-Mailer'])
            ->setHeader('MIME-Version', $headers['MIME-Version'])
            ->setHeader('Content-type', $headers['Content-type'])
            ->addTo($reservation->email)

            ->setSubject('Nová rezervace')
            ->setBody("Dobrý den,\nvaše rezervace na jméno '.$reservation->name.' byla přijata.");

        $mailer = new SendmailMailer();
        $mailer->send($mail);

    }
}
