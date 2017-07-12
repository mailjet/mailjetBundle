<?php

namespace spec\Mailjet\MailjetBundle\Manager;

use Mailjet\MailjetBundle\Exception\MailjetException;
use Mailjet\MailjetBundle\Model\Campaign;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \Mailjet\Resources;
use Mailjet\MailjetBundle\Client\MailjetClient;

class CampaignManagerSpec extends ObjectBehavior {

    public function let(MailjetClient $mailjet) {
        $this->beConstructedWith($mailjet);
    }

    public function it_is_initializable() {
        $this->shouldHaveType('Mailjet\MailjetBundle\Manager\CampaignManager');
    }

    public function it_update(MailjetClient $mailjet, \Mailjet\Response $response, $id) {
        $campaign = new Campaign("foo");
        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $id = 2;
        $mailjet->put(Resources::$Campaign, ['id' => $id, 'body' => $campaign->format()])
                ->shouldBeCalled()->willReturn($response);

        $this->updateCampaign($id, $campaign)->shouldReturn('successdata!');
    }

    public function it_get_all_campaigns(MailjetClient $mailjet, \Mailjet\Response $response) {

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $filters['FromTs'] = 0;
        $mailjet->get(Resources::$Campaign, ['filters' => $filters])->shouldBeCalled()->willReturn($response);

        $this->getAllCampaigns($filters)->shouldReturn('successdata!');
    }

    public function it_get_campaign_by_id(MailjetClient $mailjet, \Mailjet\Response $response) {

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $id = 11;
        $mailjet->get(Resources::$Campaign, ['id' => $id])->shouldBeCalled()->willReturn($response);

        $this->findByCampaignId($id)->shouldReturn('successdata!');
    }

}
