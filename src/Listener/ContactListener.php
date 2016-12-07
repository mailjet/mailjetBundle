<?php

namespace Welp\MailjetBundle\Listener;

use Welp\MailjetBundle\Service\ContactManager;
use Welp\MailjetBundle\Event\ContactEvent;

class ContactListener
{
    protected $contactManager;

    public function __construct(ContactManager $contactManager)
    {
        $this->contactManager = $contactManager;
    }

    public function onSubscribe(ContactEvent $event)
    {
        $this->contactManager->subscribe(
            $event->getListId(),
            $event->getContact()
        );
    }

    public function onUnsubscribe(ContactEvent $event)
    {
        $this->contactManager->unsubscribe(
            $event->getListId(),
            $event->getContact()
        );
    }

    public function onUpdate(ContactEvent $event)
    {
        $this->contactManager->update(
            $event->getListId(),
            $event->getContact()
        );
    }

    public function onDelete(ContactEvent $event)
    {
        $this->contactManager->delete(
            $event->getListId(),
            $event->getContact()
        );
    }

    // @TODO How to change user email? (workaround: remove old, add new...)
    /*public function onChangeEmail(ContactEvent $event)
    {
        $this->contactManager->changeEmailAddress(
            $event->getListId(),
            $event->getContact(),
            $event->getOldEmail()
        );
    }*/

}
