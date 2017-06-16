<?php

namespace spec\Mailjet\MailjetBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Mailjet\MailjetBundle\Model\Contact;
use Mailjet\MailjetBundle\Model\ContactsList;

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
        $this->shouldHaveType('Mailjet\MailjetBundle\Model\ContactsList');
    }
}
