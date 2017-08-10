<?php

namespace spec\Mailjet\MailjetBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mailjet\MailjetBundle\Model\Template;

class TemplateSpec extends ObjectBehavior
{
 const NAME_KEY = 'Name';

    public function let()
    {
        $optionalProp['Description'] = 'Foo';
        $this->beConstructedWith("bar",$optionalProp);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Model\Template');
    }


    public function it_can_get_optional_properties(){
      $this->getOptionalProperties()['Description']->shouldReturn('Foo');
    }



    public function it_can_format_properly(){
      $optionalProp['Description'] = 'Foo';
      $result[self::NAME_KEY] = "bar";
      $result = array_merge($result, $optionalProp);
      $this->format()->shouldReturn($result);
    }
}
