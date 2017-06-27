<?php

namespace spec\Mailjet\MailjetBundle\Synchronizer;

use Mailjet\MailjetBundle\Manager\ContactsListManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mailjet\MailjetBundle\Client\MailjetClient;

class ContactsListSynchronizerSpec extends ObjectBehavior
{
    public function let(MailjetClient $mailjet, ContactsListManager $manager)
    {
        $this->beConstructedWith($mailjet, $manager);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Synchronizer\ContactsListSynchronizer');
    }
}
