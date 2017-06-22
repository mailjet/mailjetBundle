<?php

namespace spec\Mailjet\MailjetBundle\DataCollector;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailjetDataCollectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\DataCollector\MailjetDataCollector');
    }
}
