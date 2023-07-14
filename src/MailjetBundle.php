<?php

namespace Mailjet\MailjetBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Mailjet\MailjetBundle\DependencyInjection\MailjetExtension;

class MailjetBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new MailjetExtension();
    }
}
