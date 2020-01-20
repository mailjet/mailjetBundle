<?php

namespace spec\Mailjet\MailjetBundle\Command;

use Mailjet\MailjetBundle\Manager\EventCallbackUrlManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;

class EventCommandSpec extends ObjectBehavior
{
    /**
     * @param  EventCallbackUrlManager $eventCallbackUrlManager
     * @param  RouterInterface         $router
     */
    public function let(
        EventCallbackUrlManager $eventCallbackUrlManager,
        RouterInterface $router
    ) {
        $this->beConstructedWith(
            $eventCallbackUrlManager,
            $router,
            'mailjet.event_endpoint_route',
            'mailjet.event_endpoint_token'
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Command\EventCommand');
    }

}
