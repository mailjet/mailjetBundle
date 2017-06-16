<?php

namespace spec\Mailjet\MailjetBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContactSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('toto@mail.fr', 'toto TATA', ['firstname' => 'toto', 'lastname'=>'tata', "gender" => "undefined"]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Model\Contact');
    }


    public function it_can_format()
    {
        $result = [
            "Email" => 'toto@mail.fr',
            "Name"  =>  'toto TATA',
            "Properties" => [
                "firstname" => "toto",
                "lastname"  => "tata",
                "gender"    =>  "undefined"
            ]
        ];

        $this->format()->shouldReturn($result);
    }
}
