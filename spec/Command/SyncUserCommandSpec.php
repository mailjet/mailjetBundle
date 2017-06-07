<?php

namespace spec\Welp\MailjetBundle\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SyncUserCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Command\SyncUserCommand');
    }
}
