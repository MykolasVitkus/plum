<?php

namespace App\Event;

use App\Service\EmailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContactSentSubscriber implements EventSubscriberInterface
{
    private $emailService;
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public static function getSubscribedEvents()
    {
        return [
            ContactSentEvent::NAME => 'onMessageSent'
        ];
    }

    public function onMessageSent(ContactSentEvent $event)
    {
        $this->emailService->sendEmail($event);
    }
}