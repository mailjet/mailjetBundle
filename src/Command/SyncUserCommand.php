<?php

namespace Welp\MailjetBundle\Command;

use \Mailjet\Client;
use \Mailjet\Resources;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Welp\MailjetBundle\Model\Contact;
use Welp\MailjetBundle\Model\ContactList;

/**
 * Class SyncUserCommand
 * Sync users in a mailjet contact list
 *
 * @package AppBundle\Command
 */
class SyncUserCommand extends ContainerAwareCommand
{
    /**
     * @var Client
     */
    private $mailjet;

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
            ->setName('mailjet:user:sync')
            ->setDescription('Synchronize users with mailjet contact list');
            // @TODO add params : listId, providerServiceKey
    }

    /**
    * {@inheritDoc}
    */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('<info>%s</info>', $this->getDescription()));

        $this->mailjet = $this->getContainer()->get('welp_mailjet.api');
        //$this->mailjetError = $this->getContainer()->get('guzzle.client.api_mailjet');
        $this->lists = $this->getContainer()->getParameter('welp_mailjet.lists');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        foreach ($this->lists as $listId => $listParameters) {
            $provider = $this->getProvider($listParameters['contact_provider']);

            $contactList = new ContactList($listId, ContactList::ACTION_ADDFORCE, $provider->getContacts());

            $response = $this->mailjet->post(Resources::$ContactslistManagemanycontacts,
                ['id' => $listId, 'body' => $contactList->format()]
            );
            if ($response->success()) {
                $this->processJob($response->getData()[0]['JobID'], $output);
            }

        }
    }

    /**
     * Treat job content
     *
     * @param int             $jobId
     * @param OutputInterface $output
     */
    private function processJob($jobId, OutputInterface $output)
    {
        $response = $this->mailjet->get(Resources::$ContactslistManagemanycontacts, ['id' => $this->list, 'actionid' => $jobId]);
        $status = $response->getData()[0]['Status'];
        /*
        switch ($status) {
            case 'Error':
                $file = $response->getData()[0]['ErrorFile'];
                $response = $this->mailjetError->get($file);
                $response->getBody()->rewind();
                $data = json_decode($response->getBody()->getContents(), true);

                foreach ($data['Contacts'] as $user) {
                    foreach ($user['Error'] as $errors) {
                        foreach ($errors as $property => $message) {
                            $output->writeln(sprintf('<error>Error on property "%s" : %s for user with email %s', $property, $message, $user['Email']));
                        }
                    }
                }
                break;
        }
        */
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
