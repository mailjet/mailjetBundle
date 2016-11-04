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

    function it_can_get()
    {

        $response = $this->get(Resources::$Campaign, ['id'=>'azrt', 'body'=>[]], ['options']);

        $this->getCalls()->shouldReturn([
            [
                'method' => 'GET',
                'resource' => Resources::$Campaign,
                'args' => ['id'=>'azrt', 'body'=>[]],
                'options' => ['options'],
                'success' => $response->success(),
                'response' => $response->getBody(),
            ]
        ]);
    }

    function it_can_put()
    {

        $response = $this->put(Resources::$Campaign, ['id'=>'azrt', 'body'=>[]], ['options']);

        $this->getCalls()->shouldReturn([
            [
                'method' => 'PUT',
                'resource' => Resources::$Campaign,
                'args' => ['id'=>'azrt', 'body'=>[]],
                'options' => ['options'],
                'success' => $response->success(),
                'response' => $response->getBody(),
            ]
        ]);
    }

    function it_can_delete()
    {

        $response = $this->delete(Resources::$Campaign, ['id'=>'azrt', 'body'=>[]], ['options']);

        $this->getCalls()->shouldReturn([
            [
                'method' => 'DELETE',
                'resource' => Resources::$Campaign,
                'args' => ['id'=>'azrt', 'body'=>[]],
                'options' => ['options'],
                'success' => $response->success(),
                'response' => $response->getBody(),
            ]
        ]);
    }

    function it_can_retrieve_several_calls()
    {

        $response = $this->post(Resources::$Campaign, ['id'=>'azrt', 'body'=>[]], ['options']);
        $response = $this->get(Resources::$Campaign, ['id'=>'azrt', 'body'=>[]], ['options']);
        $response = $this->put(Resources::$Campaign, ['id'=>'azrt', 'body'=>[]], ['options']);
        $response = $this->delete(Resources::$Campaign, ['id'=>'azrt', 'body'=>[]], ['options']);

        $this->getCalls()->shouldReturn([
            [
                'method' => 'POST',
                'resource' => Resources::$Campaign,
                'args' => ['id'=>'azrt', 'body'=>[]],
                'options' => ['options'],
                'success' => $response->success(),
                'response' => $response->getBody(),
            ],
            [
                'method' => 'GET',
                'resource' => Resources::$Campaign,
                'args' => ['id'=>'azrt', 'body'=>[]],
                'options' => ['options'],
                'success' => $response->success(),
                'response' => $response->getBody(),
            ],
            [
                'method' => 'PUT',
                'resource' => Resources::$Campaign,
                'args' => ['id'=>'azrt', 'body'=>[]],
                'options' => ['options'],
                'success' => $response->success(),
                'response' => $response->getBody(),
            ],
            [
                'method' => 'DELETE',
                'resource' => Resources::$Campaign,
                'args' => ['id'=>'azrt', 'body'=>[]],
                'options' => ['options'],
                'success' => $response->success(),
                'response' => $response->getBody(),
            ]
        ]);
    }

}
