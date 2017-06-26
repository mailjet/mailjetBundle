<?php

namespace Mailjet\MailjetBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class MailjetExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        # Client config
        $container->setParameter('mailjet.api_key', $config['api_key']);
        $container->setParameter('mailjet.secret_key', $config['secret_key']);
        $container->setParameter('mailjet.call', $config['call']);

        if (isset($config['options'])) {
            $container->setParameter('mailjet.options', $config['options']);
        } else {
            $container->setParameter('mailjet.options', array());
        }

        # Client transactionnal config
        if (isset($config['transactionnal'])) {
            $container->setParameter('mailjet.transactionnal.call', $config['transactionnal']['call']);
            if (isset($config['transactionnal']['options'])) {
                $container->setParameter('mailjet.transactionnal.options', $config['transactionnal']['options']);
            } else {
                $container->setParameter('mailjet.transactionnal.options', array());
            }
        } else {
            $container->setParameter('mailjet.transactionnal.call', true);
            $container->setParameter('mailjet.transactionnal.options', array());
        }

        # Webhook config
        $container->setParameter('mailjet.event_endpoint_route', $config['event_endpoint_route']);
        $container->setParameter('mailjet.event_endpoint_token', $config['event_endpoint_token']);

        # List config
        $container->setParameter('mailjet.lists', $config['lists']);
        # Contact Properties config
        $container->setParameter('mailjet.contact_metadata', $config['contact_metadata']);

        //set some alias
        $container->setAlias('mailjet', 'swiftmailer.mailer.transport.mailjet');

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

    public function getAlias()
    {
        return 'mailjet';
    }
}
