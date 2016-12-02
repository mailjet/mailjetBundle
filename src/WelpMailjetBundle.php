<?php

namespace Welp\MailjetBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Welp\MailjetBundle\DependencyInjection\WelpMailjetExtension;

class WelpMailjetBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new WelpMailjetExtension();
    }
}
