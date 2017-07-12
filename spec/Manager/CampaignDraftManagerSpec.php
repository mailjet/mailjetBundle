<?php

namespace spec\Mailjet\MailjetBundle\Manager;

use Mailjet\MailjetBundle\Exception\MailjetException;
use Mailjet\MailjetBundle\Model\CampaignDraft;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \Mailjet\Resources;
use Mailjet\MailjetBundle\Client\MailjetClient;

class CampaignDraftManagerSpec extends ObjectBehavior {

    public function let(MailjetClient $mailjet) {
        $this->beConstructedWith($mailjet);
    }

    public function it_is_initializable() {
        $this->shouldHaveType('Mailjet\MailjetBundle\Manager\CampaignDraftManager');
    }

    public function it_create(MailjetClient $mailjet, \Mailjet\Response $response) {
        $campaignDraft = new CampaignDraft("foo", "bar", "foo@bar", "bar", "foo");

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');

        $mailjet->post(Resources::$Campaigndraft, ['body' => $campaignDraft->format()]
        )->shouldBeCalled()->willReturn($response);

        $this->create($campaignDraft)->shouldReturn('successdata!');
    }

    public function it_throw_error_during_create(MailjetClient $mailjet, \Mailjet\Response $response) {
        $campaignDraft = new CampaignDraft("foo", "bar", "foo@bar", "bar", "foo");

        $response->success()->shouldBeCalled()->willReturn(false);
        $response->getStatus()->shouldBeCalled()->willReturn(500);
        $response->getReasonPhrase()->shouldBeCalled()->willReturn('test');
        $response->getBody()->shouldBeCalled()->willReturn(null);

        $mailjet->post(Resources::$Campaigndraft, ['body' => $campaignDraft->format()]
        )->shouldBeCalled()->willReturn($response);


        $this->shouldThrow(new MailjetException(500, "CampaignDraftManager:create() failed: test"))
                ->duringCreate($campaignDraft);
    }

    public function it_update(MailjetClient $mailjet, \Mailjet\Response $response, $id) {
        $campaignDraft = new CampaignDraft("foo", "bar", "foo@bar", "bar", "foo");
        $campaignDraft->setId(2);
        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');

        $mailjet->put(Resources::$Campaigndraft, ['id' => $campaignDraft->getId(), 'body' => $campaignDraft->format()])
                ->shouldBeCalled()->willReturn($response);

        $this->update($campaignDraft->getId(), $campaignDraft)->shouldReturn('successdata!');
    }

    public function it_get_detail_content(MailjetClient $mailjet, \Mailjet\Response $response) {

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $id = 11;
        $mailjet->get(Resources:: $CampaigndraftDetailcontent, ['id' => $id]
        )->shouldBeCalled()->willReturn($response);

        $this->getDetailContent($id)->shouldReturn('successdata!');
    }

    public function it_create_detail_content(MailjetClient $mailjet, \Mailjet\Response $response) {

        $response->success()->shouldBeCalled()->willReturn(true);
        $contentData = [
            'Html-part' => "<html><body><p>Hello {{var:name}}</p></body></html>",
            'Text-part' => "Hello {{var:name}}"
        ];
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $id = 11;
        $mailjet->post(Resources:: $CampaigndraftDetailcontent, ['id' => $id, 'body' => $contentData])->shouldBeCalled()->willReturn($response);

        $this->createDetailContent($id, $contentData)->shouldReturn('successdata!');
    }

    public function it_get_schedule(MailjetClient $mailjet, \Mailjet\Response $response) {

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $id = 11;
        $mailjet->get(Resources:: $CampaigndraftSchedule, ['id' => $id]
        )->shouldBeCalled()->willReturn($response);

        $this->getSchedule($id)->shouldReturn('successdata!');
    }

    public function it_get_campaign_status(MailjetClient $mailjet, \Mailjet\Response $response) {

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $id = 11;
        $mailjet->get(Resources:: $CampaigndraftStatus, ['id' => $id]
        )->shouldBeCalled()->willReturn($response);

        $this->getCampaignStatus($id)->shouldReturn('successdata!');
    }

}
