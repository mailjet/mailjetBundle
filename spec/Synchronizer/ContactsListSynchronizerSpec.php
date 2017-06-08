<?php

namespace spec\Welp\MailjetBundle\Synchronizer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContactsListSynchronizerSpec extends ObjectBehavior
{
    public function let(\Mailjet\Client $mailjet)
    {
        $this->beConstructedWith($mailjet);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Synchronizer\ContactsListSynchronizer');
    }
}
