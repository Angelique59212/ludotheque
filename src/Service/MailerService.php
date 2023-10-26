<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail(string $from, string $subject,string $template, array $context, string $to)
    {
        $email = (new TemplatedEmail())
            ->from($from)
            ->subject($subject)
            ->to($to)
            ->htmlTemplate($template)
            ->context($context);
        $this->mailer->send($email);
    }

    public function confirmMail(string $to, array $context)
    {
        $this->sendMail(
            'library@gmail.com',
            'Inscription',
            'emails/contact.html.twig',
            $context,
            $to,
        );
    }



}