<?php

namespace spec\Mailjet\MailjetBundle\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Mailjet\MailjetBundle\Model\Contact;

class ContactEventSpec extends ObjectBehavior
{
    public function let(Contact $contact)
    {
        $this->beConstructedWith('listid01', $contact);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Event\ContactEvent');
    }
}
