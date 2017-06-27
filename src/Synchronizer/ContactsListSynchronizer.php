<?php

namespace Mailjet\MailjetBundle\Synchronizer;

use \Mailjet\Resources;

use Mailjet\Response;
use Mailjet\MailjetBundle\Exception\MailjetException;
use Mailjet\MailjetBundle\Manager\ContactsListManager;
use Mailjet\MailjetBundle\Model\Contact;
use Mailjet\MailjetBundle\Model\ContactsList;
use Mailjet\MailjetBundle\Client\MailjetClient;

/**
* https://dev.mailjet.com/email-api/v3/contactslist-managemanycontacts/
* Service to synchronize a ContactList with MailJet server
*/
class ContactsListSynchronizer
{

    /**
     * Mailjet client
     * @var MailjetClient $mailjet
     */
    protected $mailjet;

    /**
     * ContactsList Manager
     * @var ContactsListManager $manager
     */
    protected $manager;

    /**
     * @param MailjetClient $mailjet
     * @param ContactsListManager $manager
     */
    public function __construct(MailjetClient $mailjet, ContactsListManager $manager)
    {
        $this->mailjet = $mailjet;
        $this->manager = $manager;
    }

    /**
     * Multiple contacts can be uploaded asynchronously using that action.
     *
     * @param ContactsList $contactsList
     * @return array
     */
    public function synchronize(ContactsList $contactsList)
    {

        // Remove diff Contacts
        $batchesResultRemove = $this->batchRemoveContact($contactsList);
        // Add Contacts
        $batchesResultAdd = $this->batchAddContact($contactsList);

        return array_merge($batchesResultRemove, $batchesResultAdd);
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
     * Get contacts in Mailjet list and remove the difference with $contactsList
     * @param  ContactsList $contactsList
     * @return array
     */
    private function batchRemoveContact(ContactsList $contactsList)
    {
        $emailsOnLists = [];
        $offset = 0;
        $limit = 1000;
        $run = true;

        // Retrieve Emails from list
        while ($run) {
            $filters = ['ContactsList'=> $contactsList->getListId(),'limit' => $limit, 'offset' => $offset];
            $response = $this->mailjet->get(Resources::$Contact, ['filters' => $filters]);
            if (!$response->success()) {
                $this->throwError("ContactsListSynchronizer:batchRemoveContact() failed", $response);
            }
            $data = $response->getData();

            foreach ($data as $key => $contact) {
                array_push($emailsOnLists, $contact['Email']);
            }

            $offset += $limit;
            if ($response->getCount() < $limit) {
                $run = false;
            }
        }

        $emailsInternal = array_map(function (Contact $contact) {
            return $contact->getEmail();
        }, $contactsList->getContacts());

        $diffEmails = array_diff($emailsOnLists, $emailsInternal);
        if (sizeof($diffEmails) == 0) {
            return [];
        }

        // Remove difference contacts
        $diffContacts = array_map(function ($email) {
            return new Contact($email);
        }, $diffEmails);

        $diffContactsList = new ContactsList($contactsList->getListId(), ContactsList::ACTION_REMOVE, $diffContacts);

        return $this->manager->manageManyContactsList($diffContactsList);
    }

    /**
     * Create batches to add Contacts to List
     * @param  ContactsList $contactsList
     * @return array
     */
    private function batchAddContact(ContactsList $contactsList)
    {
        $contactsList->setAction(ContactsList::ACTION_ADDFORCE);
        return $this->manager->manageManyContactsList($contactsList);
    }

    /**
     * Helper to throw error
     * @param  string $title
     * @param  Response $response
     */
    private function throwError($title, Response $response)
    {
        throw new MailjetException(0, $title, $response);
    }
}
