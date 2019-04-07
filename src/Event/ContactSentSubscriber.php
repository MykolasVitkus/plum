<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContactSentSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ContactSentEvent::NAME => 'onMessageSent'
        ];
    }

    public function onMessageSent(ContactSentEvent $event)
    {

        $mailer = new \Swift_Mailer('');
        $message = (new \Swift_Message('Dear ' . $event->getUser()->getName() . ', you have received a message'))
            ->setFrom($event->getEmail())
            ->setTo($event->getUser()->getEmail())
            ->setBody(
                $this->renderView(
                    'contact/contact_email.html.twig',
                    ['message' => $event->getMessage(),
                        'email' => $event->getEmail()]
                ),
                'text/html'
            )
        ;

        $mailer->send($message);
    }
}