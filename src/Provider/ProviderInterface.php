<?php

namespace Welp\MailjetBundle\Provider;

use Welp\MailjetBundle\Model\Contact;

interface ProviderInterface
{
    public function getSubscribers();
}
