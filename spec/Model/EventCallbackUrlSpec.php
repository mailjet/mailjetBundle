<?php

namespace spec\Mailjet\MailjetBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventCallbackUrlSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('https://foo.bar');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Model\EventCallbackUrl');
    }

    public function it_can_format()
    {

        $result = array(
            'Url' => 'https://foo.bar',
            'EventType' => 'open',
            'IsBackup'  => false,
            'Status'    => 'alive',
            'Version'   => 1
        );

        $this->format()->shouldReturn($result);
    }
}
