<?php

namespace spec\Welp\MailjetBundle\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Welp\MailjetBundle\Model\Contact;

class ContactEventSpec extends ObjectBehavior
{
    public function let(Contact $contact)
    {
        $this->beConstructedWith('listid01', $contact);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Event\ContactEvent');
    }
}
