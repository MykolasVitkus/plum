<?php

namespace App\Event;

use App\Service\EmailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContactSentSubscriber implements EventSubscriberInterface
{
    private $service;
    public function __construct(EmailService $service)
    {
        $this->service = $service;
    }

    public static function getSubscribedEvents()
    {
        return [
            ContactSentEvent::NAME => 'onMessageSent'
        ];
    }

    public function onMessageSent(ContactSentEvent $event)
    {
        $this->service->sendEmail($event);
    }
}