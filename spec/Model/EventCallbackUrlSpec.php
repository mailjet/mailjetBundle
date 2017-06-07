<?php

namespace spec\Welp\MailjetBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventCallbackUrlSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('apikeyid4550', 'https://foo.bar');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Model\EventCallbackUrl');
    }
}
