<?php

namespace spec\Welp\MailjetBundle\Command;

use Symfony\Component\DependencyInjection\ContainerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventCommandSpec extends ObjectBehavior
{
    private $uri = '/mailjet-callback';
    private $baseurl = 'https://www.welp.fr';
    private $routeName = 'welp_mailjet_endpoint';

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Welp\MailjetBundle\Command\EventCommand');
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param \Symfony\Component\Routing\RouterInterface                $router
     * @param \Symfony\Component\Console\Input\InputInterface           $input
     * @param \Symfony\Component\Console\Output\OutputInterface         $output
     */
    function it_generates_url_endpoint_without_token($container, $router, $input, $output)
    {
        $this->prepareMocks($input, $container, $router, null);

        $output->writeln($this->baseurl . $this->uri)->shouldBeCalled();

        $this->run($input, $output);
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param \Symfony\Component\Routing\RouterInterface                $router
     * @param \Symfony\Component\Console\Input\InputInterface           $input
     * @param \Symfony\Component\Console\Output\OutputInterface         $output
     */
    function it_generates_url_endpoint_with_token($container, $router, $input, $output)
    {
        $token = 12345;

        $this->prepareMocks($input, $container, $router, $token);

        $output->writeln($this->baseurl.$this->uri.'/'.$token)->shouldBeCalled();

        $this->run($input, $output);
    }

    private function prepareMocks($input, $container, $router, $token)
    {
        $input->isInteractive()->willReturn(false);
        $input->validate()->willReturn(true);
        $input->hasArgument(Argument::any())->willReturn(false);
        $input->bind(Argument::any())->shouldBeCalled();
        $input->getArgument('baseurl')->shouldBeCalled()->willReturn($this->baseurl);
        $container->getParameter('welp_mailjet.event_endpoint_route')->shouldBeCalled()->willReturn($this->routeName);
        $container->getParameter('welp_mailjet.event_endpoint_token')->shouldBeCalled()->willReturn($token);

        $uri = $this->uri.($token ? '/'.$token : '');
        $router->generate($this->routeName, array('token' => $token))->shouldBeCalled()->willReturn($uri);
        $container->get('router')->shouldBeCalled()->willReturn($router);
    }
}
