<?php

namespace spec\Mailjet\MailjetBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mailjet\MailjetBundle\Model\CampaignDraft;

class CampaignDraftSpec extends ObjectBehavior
{
    const LOCALE_KEY = 'Locale';
    const SENDER_KEY = 'Sender';
    const SENDEREMAIL_KEY = 'SenderEmail';
    const SUBJECT_KEY = 'Subject';
    const CONTACTLISTID_KEY = 'ContactsListID';
    public function let()
    {
      
        $this->beConstructedWith("en_US", "Foo", "bar@mfoo.com", "foo", "bar");
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Model\CampaignDraft');
    }


    public function it_can_set_optional_properties(){
      $optionalProp['Title'] = 'Friday newsletter';
      $this->setOptionalProperties($optionalProp);
      $this->getOptionalProperties()['Title']->shouldReturn('Friday newsletter');
    }



    public function it_can_format_properly(){
       $result[self::LOCALE_KEY] = "en_US";
       $result[self::SENDER_KEY] = "Foo";
       $result[self::SENDEREMAIL_KEY] = "bar@mfoo.com";
       $result[self::SUBJECT_KEY] = "foo";
       $result[self::CONTACTLISTID_KEY] ="bar";
       $this->format()->shouldReturn($result);
    }
}
