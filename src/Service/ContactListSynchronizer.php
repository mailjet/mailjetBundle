<?php

namespace Welp\MailjetBundle\Service;

use \Mailjet\Client;
use \Mailjet\Resources;

use Welp\MailjetBundle\Model\ContactList;

/**
* https://dev.mailjet.com/email-api/v3/contactslist-managemanycontacts/
* Service to synchronize a ContactList with MailJet server
*/
class ContactListSynchronizer
{

    protected $mailjet;

    public function __construct(\Mailjet\Client $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    

}
