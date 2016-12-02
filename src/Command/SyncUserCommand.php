<?php

namespace Welp\MailjetBundle\Command;

use Mailjet\Client;
use Mailjet\Resources;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
     * @var int
     */
    private $list;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('mailjet:user:sync')
            ->setDescription('Synchronize users with mailjet contact list')
            ->addArgument('list', InputArgument::REQUIRED, 'List ID to synchronize with');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var User[] $users */
        $users = $this->em->getRepository(User::class)->findAll();
        $body = [
            'Action' => 'addnoforce',
            'Contacts' => [],
        ];
        foreach ($users as $user) {
            $body['Contacts'][] = [
                'Email' => $user->getEmail(),
                'Name' => (string) $user,
                'Properties' => [
                    'nom' => $user->getLastName(),
                    'prenom' => $user->getFirstName(),
                    'nb_commandes' => $user->getOrderCount(),
                ],
            ];
        }

        $response = $this->mailjet->post(Resources::$ContactslistManagemanycontacts, ['id' => $this->list, 'body' => $body]);
        if ($response->success()) {
            $this->processJob($response->getData()[0]['JobID'], $output);
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
    }
}
