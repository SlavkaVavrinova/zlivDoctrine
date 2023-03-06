<?php

namespace App\Email;

use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;


class EmailService
{

    public function sendReservationEmail($dataCoPrisla)
    {
        bdump($dataCoPrisla);
        $mail = new Message();
        $headers = [
            'X-Mailer' => 'PHP/' . phpversion(),
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=UTF-8',

        ];

        //todo dataCoPrisla nahradit, až bude hotov form v next
        $mail->setFrom('Chata Růženka <chata.ruzenka@seznam.cz>')
            ->setHeader('X-Mailer', $headers['X-Mailer'])
            ->setHeader('MIME-Version', $headers['MIME-Version'])
            ->setHeader('Content-type', $headers['Content-type'])
            ->addTo($dataCoPrisla->getEmail())

            ->setSubject('Nová rezervace')
            ->setBody("Dobrý den,\nvaše rezervace na jméno '.$dataCoPrisla->getName() . ' byla přijata.");

        $mailer = new SendmailMailer();
        $mailer->send($mail);

    }
}
