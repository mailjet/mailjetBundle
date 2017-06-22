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

    public function it_throw_error_if_bad_action()
    {
        $this->beConstructedWith('listid01', 'sqdkljqslkdhnkqsj', []);
        $this->shouldThrow(new \RuntimeException("sqdkljqslkdhnkqsj: is not a valide Action."))->duringInstantiation();
    }

    public function it_can_get_listid(){
        $this->getListId()->shouldReturn('listid01');
    }

    public function it_can_get_action(){
        $this->getAction()->shouldReturn(ContactsList::ACTION_ADDFORCE);
    }

    public function it_can_get_contacts(){
        $contacts = array(
            new Contact('dede@free.fr', 'dede'),
            new Contact('foo@bar.fr', 'foo', ['foo' => 'bar'])
        );

        $this->beConstructedWith('listid01', ContactsList::ACTION_ADDFORCE, $contacts);

        $this->getContacts()->shouldReturn($contacts);
    }

    public function it_can_format_properly(){
        $result = array(
            'Action' => ContactsList::ACTION_ADDFORCE
        );

        $contacts = array(
            new Contact('dede@free.fr', 'dede'),
            new Contact('foo@bar.fr', 'foo', ['foo' => 'bar'])
        );

        $result['Contacts'] = array_map(function (Contact $contact) {
            return $contact->format();
        }, $contacts);


        $this->format()->shouldReturn($result);
    }
}
