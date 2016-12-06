<?php

namespace spec\Welp\MailjetBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContactSpec extends ObjectBehavior
{

    function let()
    {

        $this->beConstructedWith('toto@mail.fr', 'toto TATA', ['firstname' => 'toto', 'lastname'=>'tata', "gender" => "undefined"]);

    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Model\Contact');
    }


    function it_can_format(){
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
