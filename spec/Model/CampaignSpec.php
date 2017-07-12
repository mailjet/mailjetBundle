<?php

namespace spec\Mailjet\MailjetBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mailjet\MailjetBundle\Model\Campaign;

class CampaignSpec extends ObjectBehavior
{
 const FROMEMAIL_KEY = 'FromEmail';

    public function let()
    {
        $optionalProp['IsStarred'] = true;
        $this->beConstructedWith("bar",$optionalProp);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Model\Campaign');
    }


    public function it_can_get_optional_properties(){
      $this->getOptionalProperties()['IsStarred']->shouldReturn(true);
    }



    public function it_can_format_properly(){
      $optionalProp['IsStarred'] = true;
      $result[self::FROMEMAIL_KEY] = "bar";
      $result = array_merge($result, $optionalProp);
      $this->format()->shouldReturn($result);
    }
}
