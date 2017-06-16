<?php

namespace spec\Mailjet\MailjetBundle\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Controller\EventController');
    }
}
