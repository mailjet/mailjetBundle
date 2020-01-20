<?php

namespace spec\Mailjet\MailjetBundle\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mailjet\MailjetBundle\Synchronizer\ContactsListSynchronizer;

class SyncUserCommandSpec extends ObjectBehavior
{
    public function let(ContactsListSynchronizer $synchronizer)
    {
        $this->beConstructedWith($synchronizer, []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Command\SyncUserCommand');
    }
}
