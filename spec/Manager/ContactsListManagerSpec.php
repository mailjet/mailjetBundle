<?php

namespace spec\Welp\MailjetBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Welp\MailjetBundle\Client\MailjetClient;

class ContactsListManagerSpec extends ObjectBehavior
{
    public function let(MailjetClient $mailjet)
    {
        $this->beConstructedWith($mailjet);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Manager\ContactsListManager');
    }
}
