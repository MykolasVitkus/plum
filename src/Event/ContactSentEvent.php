<?php

namespace App\Event;

use App\Entity\ContactMessage;
use Symfony\Component\EventDispatcher\Event;

class ContactSentEvent extends Event
{
    const NAME = 'message.sent';
    private $message;

    public function __construct(ContactMessage $message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message->getMessage();
    }
    public function getEmail()
    {
        return $this->message->getEmail();
    }
    public function getUser()
    {
        return $this->message->getUser();
    }
}