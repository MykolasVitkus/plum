<?php


namespace App\Service;

use App\Event\ContactSentEvent;

class EmailService
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, \Twig\Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendEmail(ContactSentEvent $event)
    {
        $message = (new \Swift_Message('Dear ' . $event->getUser()->getName() . ', you have received a message'))
            ->setFrom($event->getEmail())
            ->setTo($event->getUser()->getEmail())
            ->setBody(
                $this->templating->render(
                    'contact/contact_email.html.twig',
                    ['message' => $event->getMessage(), 'email' => $event->getEmail(), 'user' => $event->getUser()]
                ),
                'text/html'
            );
        return $this->mailer->send($message);
    }
}