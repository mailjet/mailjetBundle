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

    public function it_can_get_listid()
    {
        $this->getListId()->shouldReturn('listid01');
    }

    public function it_can_get_contact(Contact $contact)
    {
        $this->getContact()->shouldReturn($contact);
    }

    public function it_get_oldemail(Contact $contact){
        $this->beConstructedWith('listid01', $contact, 'oldemail@foo.bar');

        $this->getOldEmail()->shouldReturn('oldemail@foo.bar');
    }
}
