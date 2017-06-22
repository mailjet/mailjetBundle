<?php

namespace spec\Mailjet\MailjetBundle\Listener;

use Mailjet\MailjetBundle\Model\Contact;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Mailjet\MailjetBundle\Manager\ContactsListManager;
use Mailjet\MailjetBundle\Event\ContactEvent;

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

    public function it_on_subcribe(ContactsListManager $contactsListManager)
    {
        $event =  new ContactEvent('listid01', new Contact('email@foo.bar', 'foo Bar'));
        $contactsListManager->subscribe($event->getListId(), $event->getContact())->shouldBeCalled();
        $this->onSubscribe($event);
    }

    public function it_on_unsubcribe(ContactsListManager $contactsListManager)
    {
        $event =  new ContactEvent('listid01', new Contact('email@foo.bar', 'foo Bar'));
        $contactsListManager->unsubscribe($event->getListId(), $event->getContact())->shouldBeCalled();
        $this->onUnsubscribe($event);
    }

    public function it_on_update(ContactsListManager $contactsListManager)
    {
        $event =  new ContactEvent('listid01', new Contact('email@foo.bar', 'foo Bar'));
        $contactsListManager->update($event->getListId(), $event->getContact())->shouldBeCalled();
        $this->onUpdate($event);
    }

    public function it_on_delete(ContactsListManager $contactsListManager)
    {
        $event =  new ContactEvent('listid01', new Contact('email@foo.bar', 'foo Bar'));
        $contactsListManager->delete($event->getListId(), $event->getContact())->shouldBeCalled();
        $this->onDelete($event);
    }

    public function it_on_change_email(ContactsListManager $contactsListManager)
    {
        $event =  new ContactEvent('listid01', new Contact('email@foo.bar', 'foo Bar'), 'oldemail@foo.bar');
        $contactsListManager->changeEmail($event->getListId(), $event->getContact(), 'oldemail@foo.bar')->shouldBeCalled();
        $this->onChangeEmail($event);
    }
}
