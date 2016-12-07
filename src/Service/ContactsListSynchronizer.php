<?php

namespace Welp\MailjetBundle\Service;

use \Mailjet\Client;
use \Mailjet\Resources;

use Welp\MailjetBundle\Model\ContactsList;

/**
* https://dev.mailjet.com/email-api/v3/contactslist-managemanycontacts/
* Service to synchronize a ContactList with MailJet server
*/
class ContactsListSynchronizer
{
    const CONTACT_BATCH_SIZE = 500;

    protected $mailjet;

    public function __construct(\Mailjet\Client $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * Multiple contacts can be uploaded asynchronously using that action.
     *
     * @param ContactsList $contactsList
     * @return dataResponse
     */
    public function synchronize(ContactsList $contactsList)
    {
        $batchResults = [];
        // we send multiple smaller requests instead of a bigger one
        $contactChunks = array_chunk($contactsList->getContacts(), self::CONTACT_BATCH_SIZE);
        foreach ($contactChunks as $contactChunk) {
            // create a sub-contactList to divide large request
            $subContactsList = new ContactsList($contactsList->getListId(), $contactsList->getAction(), $contactChunk);
            $currentBatch = $this->mailjet->post(Resources::$ContactslistManagemanycontacts,
                ['id' => $subContactsList->getListId(), 'body' => $subContactsList->format()]
            );
            array_push($batchResults, $currentBatch);
        }
        return $batchResults;
    }
}
