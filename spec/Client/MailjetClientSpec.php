<?php

namespace spec\Mailjet\MailjetBundle\Client;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailjetClientSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('api_key', 'api_secret');
    }


    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Client\MailjetClient');
    }
}
