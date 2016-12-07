<?php

namespace Welp\MailjetBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Welp\MailjetBundle\Model\Contact;

class ContactEvent extends Event
{
    const EVENT_SUBSCRIBE = 'welp.mailjet.subscribe';
    const EVENT_UNSUBSCRIBE = 'welp.mailjet.unsubscribe';
    const EVENT_UPDATE = 'welp.mailjet.update';
    const EVENT_DELETE = 'welp.mailjet.delete';
    const EVENT_CHANGE_EMAIL = 'welp.mailjet.change_email'; # not implemented yet

    protected $listId;
    protected $contact;
    protected $oldEmail;

    public function __construct($listId, Contact $contact, $oldEmail = null)
    {
        $this->listId = $listId;
        $this->contact = $contact;
        $this->oldEmail = $oldEmail;
    }

    public function getListId()
    {
        return $this->listId;
    }

    public function getContact()
    {
        return $this->contact;
    }

    public function getOldEmail()
    {
        return $this->oldEmail;
    }
}
