<?php

namespace spec\Welp\MailjetBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContactsListManagerSpec extends ObjectBehavior
{
    public function let(\Mailjet\Client $mailjet)
    {
        $this->beConstructedWith($mailjet);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Manager\ContactsListManager');
    }
}
