<?php

namespace App\Service;

use App\Entity\User;
use App\Service\MessageGenerator;


class ServiceSendMAil
{
    private User $user;
    private  $messageGenerator;
    private $mailer;

    public function __construct(MessageGenerator $messageGenerator, \Swift_Mailer $mailer)
    {
        $this->messageGenerator = $messageGenerator;
        $this->mailer = $mailer;
    }

    public function sendMailaddUser(): bool
    {
        $happyMessage = $this->messageGenerator->getHappyMessage();

        $message = (new \Swift_Message('Orange Digital Center'))
            ->setFrom('rajerr2013@gmail.com')
            ->setTo($user->getEmail())
            ->setBody("mot de passe est $password , et le username " . $username)
            ->text('Le mail de validation a été envoté avec success: '.$happyMessage);
        $mailer->send($message);

        return true;
    }
}