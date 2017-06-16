<?php

namespace Mailjet\MailjetBundle\Provider;

use Mailjet\MailjetBundle\Model\Contact;

interface ProviderInterface
{
    public function getContacts();
}
