<?php

namespace spec\Mailjet\MailjetBundle\Synchronizer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mailjet\MailjetBundle\Client\MailjetClient;

class ContactsListSynchronizerSpec extends ObjectBehavior
{
    public function let(MailjetClient $mailjet)
    {
        $this->beConstructedWith($mailjet);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Synchronizer\ContactsListSynchronizer');
    }
}
