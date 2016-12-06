<?php
namespace Welp\MailjetBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Documentation : https://dev.mailjet.com/email-api/v3/eventcallbackurl/
 */
class CallbackEvent extends Event
{
    const EVENT_SENT = 'welp.mailjet.event.sent';
    const EVENT_OPEN = 'welp.mailjet.event.open';
    const EVENT_CLICK = 'welp.mailjet.event.click';
    const EVENT_BOUNCE = 'welp.mailjet.event.bounce';
    const EVENT_SPAM = 'welp.mailjet.event.spam';
    const EVENT_BLOCKED = 'welp.mailjet.event.blocked';
    const EVENT_UNSUB = 'welp.mailjet.event.unsub';
    const EVENT_TYPOFIX = 'welp.mailjet.event.typofix';
    const EVENT_PARSEAPI = 'welp.mailjet.event.parseapi';
    const EVENT_NEWSENDER = 'welp.mailjet.event.newsender';
    const EVENT_NEWSENDERAUTOVALID = 'welp.mailjet.event.newsenderautovalid';

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
