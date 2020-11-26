<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Validator\ValidatorInterface;

class ServiceSendMail
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMailaddUser($user): bool
    {
        $message = (new \Swift_Message('Orange Digital Center'))

            ->setFrom('rajerr2013@gmail.com')
            ->setTo($user->getEmail())
            ->setBody("mot de passe est ".$user->getPassword()." , et le username " . $user->getUsername());

        $mailer->send($message);

        return true;
    }
    }