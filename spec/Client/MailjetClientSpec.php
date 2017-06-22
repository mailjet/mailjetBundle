<?php

namespace spec\Mailjet\MailjetBundle\Client;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailjetClientSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Client\MailjetClient');
    }
}
