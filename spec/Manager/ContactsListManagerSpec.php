<?php

namespace spec\Mailjet\MailjetBundle\Manager;

use Mailjet\MailjetBundle\Exception\MailjetException;
use Mailjet\MailjetBundle\Model\Contact;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \Mailjet\Resources;

use Mailjet\MailjetBundle\Client\MailjetClient;

class ContactsListManagerSpec extends ObjectBehavior
{
    public function let(MailjetClient $mailjet)
    {
        $this->beConstructedWith($mailjet);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Manager\ContactsListManager');
    }

    public function it_create(MailjetClient $mailjet, \Mailjet\Response $response)
    {
        $contact = new Contact('foo@bar');
        $contact->setAction(Contact::ACTION_ADDFORCE);

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');

        $mailjet->post(Resources::$ContactslistManagecontact,
            ['id' => 'list01', 'body' => $contact->format()]
        )->shouldBeCalled()->willReturn($response);

        $this->create('list01', $contact)->shouldReturn('successdata!');
    }

    public function it_throw_error_during_create(MailjetClient $mailjet, \Mailjet\Response $response)
    {
        $contact = new Contact('foo@bar');
        $contact->setAction(Contact::ACTION_ADDFORCE);

        $response->success()->shouldBeCalled()->willReturn(false);
        $response->getStatus()->shouldBeCalled()->willReturn(500);
        $response->getReasonPhrase()->shouldBeCalled()->willReturn('test');
        $response->getBody()->shouldBeCalled()->willReturn(null);

        $mailjet->post(Resources::$ContactslistManagecontact,
            ['id' => 'list01', 'body' => $contact->format()]
        )->shouldBeCalled()->willReturn($response);


        $this->shouldThrow(new MailjetException(500, "ContactsListManager:create() failed: test"))
            ->duringCreate('list01', $contact);
    }

    public function it_update(MailjetClient $mailjet, \Mailjet\Response $response)
    {
        $contact = new Contact('foo@bar');
        $contact->setAction(Contact::ACTION_ADDNOFORCE);

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');

        $mailjet->post(Resources::$ContactslistManagecontact,
            ['id' => 'list01', 'body' => $contact->format()]
        )->shouldBeCalled()->willReturn($response);

        $this->update('list01', $contact)->shouldReturn('successdata!');
    }

    public function it_subscribe(MailjetClient $mailjet, \Mailjet\Response $response)
    {
        $contact = new Contact('foo@bar');
        $contact->setAction(Contact::ACTION_ADDFORCE);

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');

        $mailjet->post(Resources::$ContactslistManagecontact,
            ['id' => 'list01', 'body' => $contact->format()]
        )->shouldBeCalled()->willReturn($response);

        $this->subscribe('list01', $contact)->shouldReturn('successdata!');
    }

    public function it_unsubscribe(MailjetClient $mailjet, \Mailjet\Response $response)
    {
        $contact = new Contact('foo@bar');
        $contact->setAction(Contact::ACTION_UNSUB);

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');

        $mailjet->post(Resources::$ContactslistManagecontact,
            ['id' => 'list01', 'body' => $contact->format()]
        )->shouldBeCalled()->willReturn($response);

        $this->unsubscribe('list01', $contact)->shouldReturn('successdata!');
    }

    public function it_delete(MailjetClient $mailjet, \Mailjet\Response $response)
    {
        $contact = new Contact('foo@bar');
        $contact->setAction(Contact::ACTION_REMOVE);

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');

        $mailjet->post(Resources::$ContactslistManagecontact,
            ['id' => 'list01', 'body' => $contact->format()]
        )->shouldBeCalled()->willReturn($response);

        $this->delete('list01', $contact)->shouldReturn('successdata!');
    }

    public function it_change_email(MailjetClient $mailjet, \Mailjet\Response $response, \Mailjet\Response $responseFinal)
    {
        $contact = new Contact('foo@bar');
        $contact->setAction(Contact::ACTION_ADDFORCE);

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn(['Data' => ['foo' => 'bar']]);

        $mailjet->get(Resources::$Contactdata, ['id' => 'oldemail@foo.bar'])
            ->shouldBeCalled()
            ->willReturn($response);
        $contact->setProperties(['foo' => 'bar']);
        $mailjet->post(Resources::$ContactslistManagecontact, ['id' => 'list01', 'body' => $contact->format()])
            ->shouldBeCalled()
            ->willReturn($response);

        $oldContact = new Contact('oldemail@foo.bar');
        $oldContact->setAction(Contact::ACTION_REMOVE);

        $responseFinal->success()->shouldBeCalled()->willReturn(true);
        $responseFinal->getData()->shouldBeCalled()->willReturn('success');

        $mailjet->post(Resources::$ContactslistManagecontact, ['id' => 'list01', 'body' => $oldContact->format()])
            ->shouldBeCalled()
            ->willReturn($responseFinal);

        $this->changeEmail('list01', $contact, 'oldemail@foo.bar')->shouldReturn('success');
    }
}
