<?php

namespace Mailjet\MailjetBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Mailjet\MailjetBundle\DependencyInjection\MailjetMailjetExtension;

class MailjetBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new MailjetExtension();
    }
}
