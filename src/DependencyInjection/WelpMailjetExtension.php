<?php

namespace Welp\MailjetBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class WelpMailjetExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('welp_mailjet.api_key', $config['api_key']);
        $container->setParameter('welp_mailjet.secret_key', $config['secret_key']);
        $container->setParameter('welp_mailjet.event_endpoint_route', $config['event_endpoint_route']);
        $container->setParameter('welp_mailjet.event_endpoint_token', $config['event_endpoint_token']);
        $container->setParameter('welp_mailjet.lists', $config['lists']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

    public function getAlias()
    {
        return 'welp_mailjet';
    }
}
