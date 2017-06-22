<?php

namespace spec\Mailjet\MailjetBundle\DataCollector;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Mailjet\MailjetBundle\Client\MailjetClient;

class MailjetDataCollectorSpec extends ObjectBehavior
{
    public function let(MailjetClient $mailjet)
    {
        $this->beConstructedWith($mailjet, $mailjet);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\DataCollector\MailjetDataCollector');
    }
}
