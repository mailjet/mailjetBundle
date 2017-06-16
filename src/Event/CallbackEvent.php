<?php
namespace Mailjet\MailjetBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Documentation : https://dev.mailjet.com/email-api/v3/eventcallbackurl/
 */
class CallbackEvent extends Event
{
    
    const EVENT_SENT = 'mailjet.mailjet.event.sent';
    const EVENT_OPEN = 'mailjet.mailjet.event.open';
    const EVENT_CLICK = 'mailjet.mailjet.event.click';
    const EVENT_BOUNCE = 'mailjet.mailjet.event.bounce';
    const EVENT_SPAM = 'mailjet.mailjet.event.spam';
    const EVENT_BLOCKED = 'mailjet.mailjet.event.blocked';
    const EVENT_UNSUB = 'mailjet.mailjet.event.unsub';
    const EVENT_TYPOFIX = 'mailjet.mailjet.event.typofix';
    const EVENT_PARSEAPI = 'mailjet.mailjet.event.parseapi';
    const EVENT_NEWSENDER = 'mailjet.mailjet.event.newsender';
    const EVENT_NEWSENDERAUTOVALID = 'mailjet.mailjet.event.newsenderautovalid';

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

}
