<?php

namespace spec\Welp\MailjetBundle\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Controller\EventController');
    }
}
