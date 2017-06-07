<?php

namespace spec\Welp\MailjetBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Welp\MailjetBundle\Model\Contact;
use Welp\MailjetBundle\Model\ContactsList;

class ContactsListSpec extends ObjectBehavior
{
    public function let()
    {
        $contacts = array(
            new Contact('dede@free.fr', 'dede'),
            new Contact('foo@bar.fr', 'foo', ['foo' => 'bar'])
        );

        $this->beConstructedWith('listid01', ContactsList::ACTION_ADDFORCE, $contacts);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Model\ContactsList');
    }
}
