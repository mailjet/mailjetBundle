<?php

namespace Welp\MailjetBundle\Command;

use \Mailjet\Client;
use \Mailjet\Resources;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Welp\MailjetBundle\Model\Contact;
use Welp\MailjetBundle\Model\ContactsList;

/**
 * Class SyncUserCommand
 * Sync users in a mailjet contact list
 *
 * @package AppBundle\Command
 */
class SyncUserCommand extends ContainerAwareCommand
{

    /**
     * @var Array
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

            $contactList = new ContactsList($listId, ContactsList::ACTION_ADDNOFORCE, $provider->getContacts());

            $response = $this->getContainer()->get('welp_mailjet.service.contacts_list_synchronizer')->synchronize($contactList);
            //@TODO get responses + parse all batch responses + show/format error + show result/count import

            $output->writeln(sprintf('<info>OK listId: %s</info>', $listId));
        }
    }

    /**
     * Get contact provider
     * @param String $providerServiceKey
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
