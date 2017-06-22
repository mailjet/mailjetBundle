<?php

namespace spec\Mailjet\MailjetBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContactMetadataManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Manager\ContactMetadataManager');
    }
}
