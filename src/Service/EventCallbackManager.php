<?php

namespace Welp\MailjetBundle\Service;

use \Mailjet\Client;
use \Mailjet\Resources;

/**
* https://dev.mailjet.com/email-api/v3/eventcallbackurl/
* Manage EventCallback
*/
class EventCallbackManager
{

    protected $mailjet;

    public function __construct(\Mailjet\Client $mailjet)
    {
        $this->mailjet = $mailjet;
    }

}
