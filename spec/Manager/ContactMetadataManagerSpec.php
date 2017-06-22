<?php

namespace spec\Mailjet\MailjetBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Mailjet\MailjetBundle\Client\MailjetClient;


class ContactMetadataManagerSpec extends ObjectBehavior
{

    public function let(MailjetClient $mailjet)
    {
        $this->beConstructedWith($mailjet);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Manager\ContactMetadataManager');
    }
}
