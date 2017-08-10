<?php

namespace spec\Mailjet\MailjetBundle\Manager;

use Mailjet\MailjetBundle\Exception\MailjetException;
use Mailjet\MailjetBundle\Model\Template;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \Mailjet\Resources;
use Mailjet\MailjetBundle\Client\MailjetClient;

class TemplateManagerSpec extends ObjectBehavior {

    public function let(MailjetClient $mailjet) {
        $this->beConstructedWith($mailjet);
    }

    public function it_is_initializable() {
        $this->shouldHaveType('Mailjet\MailjetBundle\Manager\TemplateManager');
    }

    public function it_create(MailjetClient $mailjet, \Mailjet\Response $response, $id) {
        $template = new Template("foo");
        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $mailjet->post(Resources::$Template, ['body' => $template->format()])
                ->shouldBeCalled()->willReturn($response);

        $this->create($template)->shouldReturn('successdata!');
    }

    public function it_update(MailjetClient $mailjet, \Mailjet\Response $response, $id) {
        $template = new Template("foo");
        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $id = 2;
        $mailjet->put(Resources::$Template, ['id' => $id, 'body' => $template->format()])
                ->shouldBeCalled()->willReturn($response);

        $this->update($id, $template)->shouldReturn('successdata!');
    }

    public function it_get_all_templates(MailjetClient $mailjet, \Mailjet\Response $response) {

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $filters['Categories'] = "sport";
        $mailjet->get(Resources::$Template, ['filters' => $filters])->shouldBeCalled()->willReturn($response);

        $this->getAll($filters)->shouldReturn('successdata!');
    }

    public function it_get_template_by_id(MailjetClient $mailjet, \Mailjet\Response $response) {

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $id = 11;
        $mailjet->get(Resources::$Template, ['id' => $id])->shouldBeCalled()->willReturn($response);

        $this->get($id)->shouldReturn('successdata!');
    }

    public function it_delete_template(MailjetClient $mailjet, \Mailjet\Response $response) {

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $id = 11;
        $mailjet->delete(Resources::$Template, ['id' => $id])->shouldBeCalled()->willReturn($response);

        $this->delete($id)->shouldReturn('successdata!');
    }

    public function it_get_detail_content(MailjetClient $mailjet, \Mailjet\Response $response) {

        $response->success()->shouldBeCalled()->willReturn(true);
        $response->getData()->shouldBeCalled()->willReturn('successdata!');
        $id = 11;
        $mailjet->get(Resources:: $TemplateDetailcontent, ['id' => $id]
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
        $mailjet->post(Resources:: $TemplateDetailcontent, ['id' => $id, 'body' => $contentData])->shouldBeCalled()->willReturn($response);

        $this->createDetailContent($id, $contentData)->shouldReturn('successdata!');
    }

}
