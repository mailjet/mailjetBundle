<?php

namespace spec\Mailjet\MailjetBundle\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SyncContactMetadataCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Command\SyncContactMetadataCommand');
    }
}
