<?php

namespace spec\Welp\MailjetBundle\Listener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Welp\MailjetBundle\Manager\ContactsListManager;

class ContactListenerSpec extends ObjectBehavior
{
    public function let(ContactsListManager $contactsListManager)
    {
        $this->beConstructedWith($contactsListManager);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Listener\ContactListener');
    }
}
