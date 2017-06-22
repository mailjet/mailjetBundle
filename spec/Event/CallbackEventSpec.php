<?php

namespace spec\Mailjet\MailjetBundle\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CallbackEventSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(json_decode('{
          "MessageID": 18859015918863550,
          "customcampaign": "",
          "email": "api@mailjet.com",
          "event": "sent",
          "mj_campaign_id": 2970263,
          "mj_contact_id": 7780691,
          "mj_message_id": "18859015918863553",
          "smtp_reply": "sent (250 2.0.0 OK 1496823341 f85si1543883wmh.76 - gsmtp)",
          "time": 1496823342
      }', true));
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Event\CallbackEvent');
    }

    public function it_can_get_data()
    {
        $this->getData()->shouldReturn(json_decode('{
          "MessageID": 18859015918863550,
          "customcampaign": "",
          "email": "api@mailjet.com",
          "event": "sent",
          "mj_campaign_id": 2970263,
          "mj_contact_id": 7780691,
          "mj_message_id": "18859015918863553",
          "smtp_reply": "sent (250 2.0.0 OK 1496823341 f85si1543883wmh.76 - gsmtp)",
          "time": 1496823342
      }', true));
    }
}
