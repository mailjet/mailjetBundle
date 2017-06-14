<?php

namespace Welp\MailjetBundle\Manager;

use \Mailjet\Resources;

use Welp\MailjetBundle\Client\MailjetClient;
use Welp\MailjetBundle\Model\Contact;

/**
* https://dev.mailjet.com/email-api/v3/contactslist-managecontact/
* manage ContactsList (create, update, delete, ...)
*
*/
class ContactsListManager
{
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
     * create a new fresh Contact to listId
     * @param string $listId
     * @param Contact $contact
     * @param string $action
     */
    public function create($listId, Contact $contact, $action=Contact::ACTION_ADDFORCE)
    {
        $contact->setAction($action);
        $response = $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactsListManager:create() failed:", $response);
        }

        return $response->getData();
    }

    /**
     * update a Contact to listId
     */
    public function update($listId, Contact $contact, $action=Contact::ACTION_ADDNOFORCE)
    {
        $contact->setAction($action);
        $response = $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactsListManager:update() failed:", $response);
        }

        return $response->getData();
    }

    /**
     * re/subscribe a Contact to listId
     */
    public function subscribe($listId, Contact $contact, $force = true)
    {
        if ($force) {
            $contact->setAction(Contact::ACTION_ADDFORCE);
        } else {
            $contact->setAction(Contact::ACTION_ADDNOFORCE);
        }
        $response = $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactsListManager:sub() failed:", $response);
        }

        return $response->getData();
    }

    /**
     * unsubscribe a Contact from listId
     */
    public function unsubscribe($listId, Contact $contact)
    {
        $contact->setAction(Contact::ACTION_UNSUB);
        $response = $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactsListManager:unsub() failed:", $response);
        }

        return $response->getData();
    }

    /**
     * Delete a Contact from listId
     */
    public function delete($listId, Contact $contact)
    {
        $contact->setAction(Contact::ACTION_REMOVE);
        $response = $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactsListManager:delete() failed:", $response);
        }

        return $response->getData();
    }

    /*
     * Change email a Contact
     *
    public function changeEmail(Contact $contact, $oldEmail)
    {
        //@TODO
    }*/

    /**
    * An action for adding a contact to a contact list. Only POST is supported.
    * The API will internally create the new contact if it does not exist,
    * add or update the name and properties.
    * The properties have to be defined before they can be used.
    * The API then adds the contact to the contact list with active=true and
    * unsub=specified value if it is not already in the list,
    * or updates the entry with these values. On success,
    * the API returns a packet with the same format but with all properties available
    * for that contact.
    */
    private function _exec($listId, Contact $contact)
    {
        return $this->mailjet->post(Resources::$ContactslistManagecontact,
            ['id' => $listId, 'body' => $contact->format()]
        );
    }

    /**
     * Helper to throw error
     * @param  string $title
     * @param  array $response
     */
    private function throwError($title, $response)
    {
        throw new \RuntimeException($title.": ".$response->getReasonPhrase());
    }
}
