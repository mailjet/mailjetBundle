<?php

namespace spec\Mailjet\MailjetBundle\Listener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Mailjet\MailjetBundle\Manager\ContactsListManager;

class ContactListenerSpec extends ObjectBehavior
{
    public function let(ContactsListManager $contactsListManager)
    {
        $this->beConstructedWith($contactsListManager);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Listener\ContactListener');
    }
}
