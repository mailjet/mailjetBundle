<?php

namespace Welp\MailjetBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

use Welp\MailjetBundle\Model\ContactsList;
use Welp\MailjetBundle\Provider\ProviderInterface;

/**
 * Class SyncUserCommand
 * Sync users in a mailjet contact list
 *
 */
class SyncUserCommand extends ContainerAwareCommand
{

    /**
     * @var array
     */
    private $lists;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('welp:mailjet:user-sync')
            ->setDescription('Synchronize users with mailjet contact list');
            // @TODO add params : listId, providerServiceKey
    }

    /**
    * {@inheritDoc}
    */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('<info>%s</info>', $this->getDescription()));

        $this->lists = $this->getContainer()->getParameter('welp_mailjet.lists');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->lists as $listId => $listParameters) {
            $provider = $this->getProvider($listParameters['contact_provider']);

            $contactList = new ContactsList($listId, ContactsList::ACTION_ADDFORCE, $provider->getContacts());

            $response = $this->getContainer()->get('welp_mailjet.service.contacts_list_synchronizer')->synchronize($contactList);
            //@TODO get responses + parse all batch responses + show/format error + show result/count import
            // We need to retrieve Errors_logs file but in Mailjet UI it throw 500 error...

            $output->writeln(sprintf('<info>OK listId: %s, see logs in Mailjet List</info>', $listId));
        }
    }

    /**
     * Get contact provider
     * @param string $providerServiceKey
     * @return ProviderInterface $provider
     */
    private function getProvider($providerServiceKey)
    {
        try {
            $provider = $this->getContainer()->get($providerServiceKey);
        } catch (ServiceNotFoundException $e) {
            throw new \InvalidArgumentException(sprintf('Provider "%s" should be defined as a service.', $providerServiceKey), $e->getCode(), $e);
        }
        if (!$provider instanceof ProviderInterface) {
            throw new \InvalidArgumentException(sprintf('Provider "%s" should implement Welp\MailjetBundle\Provider\ProviderInterface.', $providerServiceKey));
        }
        return $provider;
    }
}
