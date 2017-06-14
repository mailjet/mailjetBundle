<?php

namespace spec\Welp\MailjetBundle\Synchronizer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Welp\MailjetBundle\Client\MailjetClient;

class ContactsListSynchronizerSpec extends ObjectBehavior
{
    public function let(MailjetClient $mailjet)
    {
        $this->beConstructedWith($mailjet);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Synchronizer\ContactsListSynchronizer');
    }
}
