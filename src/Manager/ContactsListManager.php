<?php

namespace Mailjet\MailjetBundle\Manager;

use \Mailjet\Resources;
use \Mailjet\Response;

use Mailjet\MailjetBundle\Client\MailjetClient;
use Mailjet\MailjetBundle\Exception\MailjetException;
use Mailjet\MailjetBundle\Model\Contact;

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
            $this->throwError("ContactsListManager:create() failed", $response);
        }

        return $response->getData();
    }

    /**
     * update a Contact to listId
     * @param string $listId
     * @param Contact $contact
     * @param string $action
     */
    public function update($listId, Contact $contact, $action=Contact::ACTION_ADDNOFORCE)
    {
        $contact->setAction($action);
        $response = $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactsListManager:update() failed", $response);
        }

        return $response->getData();
    }

    /**
     * re/subscribe a Contact to listId
     * @param string $listId
     * @param Contact $contact
     * @param bool $force
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
            $this->throwError("ContactsListManager:sub() failed", $response);
        }

        return $response->getData();
    }

    /**
     * unsubscribe a Contact from listId
     * @param string $listId
     * @param Contact $contact
     */
    public function unsubscribe($listId, Contact $contact)
    {
        $contact->setAction(Contact::ACTION_UNSUB);
        $response = $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactsListManager:unsub() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Delete a Contact from listId
     * @param string $listId
     * @param Contact $contact
     */
    public function delete($listId, Contact $contact)
    {
        $contact->setAction(Contact::ACTION_REMOVE);
        $response = $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactsListManager:delete() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Change email a Contact
     * @param string $listId
     * @param Contact $contact
     * @param string $oldEmail
     */
    public function changeEmail($listId, Contact $contact, $oldEmail)
    {
        // get old contact properties
        $response = $this->mailjet->get(Resources::$Contactdata, ['id' => $oldEmail]);
        if (!$response->success()) {
            $this->throwError("ContactsListManager:changeEmail() failed", $response);
        }

        // copy contact properties
        $oldContactData = $response->getData();
        if (isset($oldContactData[0])) {
            $contact->setProperties($oldContactData[0]['Data']);
        }

        // add new contact
        $contact->setAction(Contact::ACTION_ADDFORCE);
        $response = $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactsListManager:changeEmail() failed", $response);
        }

        // remove old
        $oldContact = new Contact($oldEmail);
        $oldContact->setAction(Contact::ACTION_REMOVE);
        $response = $this->_exec($listId, $oldContact);
        if (!$response->success()) {
            $this->throwError("ContactsListManager:changeEmail() failed", $response);
        }

        return $response->getData();
    }

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
    * @param string $listId
    * @param Contact $contact
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
     * @param  Response $response
     * @param  array $response
     */
     private function throwError($title, Response $response)
     {
         throw new MailjetException(0, $title, $response);
     }
}
