<?php

namespace spec\Mailjet\MailjetBundle\Command;

use Symfony\Component\DependencyInjection\ContainerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventCommandSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Command\EventCommand');
    }

}
