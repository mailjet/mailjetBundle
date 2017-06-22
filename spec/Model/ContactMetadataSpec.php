<?php

namespace spec\Mailjet\MailjetBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContactMetadataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Model\ContactMetadata');
    }
}
