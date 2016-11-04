<?php

namespace spec\Mailjet\MailjetBundle\Client;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Mailjet\Resources;

class MailjetClientSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('api_key', 'api_secret', false);
    }


    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Client\MailjetClient');
        $this->shouldHaveType('Mailjet\Client');
    }

    function it_can_post()
    {

        $response = $this->post(Resources::$Campaign, ['id'=>'azrt', 'body'=>[]], ['options']);

        $this->getCalls()->shouldReturn([
            [
                'method' => 'POST',
                'resource' => Resources::$Campaign,
                'args' => ['id'=>'azrt', 'body'=>[]],
                'options' => ['options'],
                'success' => $response->success(),
                'response' => $response->getBody(),
            ]
        ]);
    }
}
