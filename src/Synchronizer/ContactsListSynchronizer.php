<?php

namespace Mailjet\MailjetBundle\Synchronizer;

use \Mailjet\Resources;

use Mailjet\Response;
use Mailjet\MailjetBundle\Exception\MailjetException;
use Mailjet\MailjetBundle\Model\ContactsList;
use Mailjet\MailjetBundle\Client\MailjetClient;

/**
* https://dev.mailjet.com/email-api/v3/contactslist-managemanycontacts/
* Service to synchronize a ContactList with MailJet server
*/
class ContactsListSynchronizer
{
    /**
     * @var int
     */
    const CONTACT_BATCH_SIZE = 500;

    /**
     * Mailjet client
     * @var MailjetClient
     */
    protected $mailjet;

    /**
     * @param MailjetClient $mailjet
     */
    public function __construct(MailjetClient $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * Multiple contacts can be uploaded asynchronously using that action.
     *
     * @param ContactsList $contactsList
     * @return array
     */
    public function synchronize(ContactsList $contactsList)
    {
        // @TODO remove users which are not provided
        $batchResults = [];
        // we send multiple smaller requests instead of a bigger one
        $contactChunks = array_chunk($contactsList->getContacts(), self::CONTACT_BATCH_SIZE);
        foreach ($contactChunks as $contactChunk) {
            // create a sub-contactList to divide large request
            $subContactsList = new ContactsList($contactsList->getListId(), $contactsList->getAction(), $contactChunk);
            $currentBatch = $this->mailjet->post(Resources::$ContactslistManagemanycontacts,
                ['id' => $subContactsList->getListId(), 'body' => $subContactsList->format()]
            );
            if ($currentBatch->success()) {
                array_push($batchResults, $currentBatch->getData()[0]);
            } else {
                $this->throwError("ContactsListSynchronizer:synchronize() failed", $currentBatch);
            }
        }
        return $batchResults;
    }

    /**
     * Get Job data
     * @method getJob
     * @param  string $listId
     * @param  string $jobId
     * @return array
     */
    public function getJob($listId, $jobId)
    {
        $response = $this->mailjet->get(Resources::$ContactslistManagemanycontacts, ['id' => $listId, 'actionid' => $jobId]);
        if (!$response->success()) {
            $this->throwError("ContactsListSynchronizer:getJob() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Retrieve JsonError for a job
     * @param  string $jobId
     * @return array
     */
    public function getJobJsonError($jobId)
    {
        $response = $this->mailjet->get(Resources::$BatchjobJsonerror, ['id' => $jobId]);
        if (!$response->success()) {
            $this->throwError("ContactsListSynchronizer:getJobJsonError() failed", $response);
        }

        return $response->getBody();
    }

    /**
     * Helper to throw error
     * @param  string $title
     * @param  array $response
     */
    private function throwError($title, Response $response)
    {
        throw new MailjetException(0, $title, $response);
    }
}
