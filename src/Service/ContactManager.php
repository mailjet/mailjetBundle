<?php

namespace Welp\MailjetBundle\Service;

use \Mailjet\Resources;

use Welp\MailjetBundle\Model\Contact;

/**
* https://dev.mailjet.com/email-api/v3/contactslist-managecontact/
* manage Contact (create, update, delete, ...)
*
*/
class ContactManager
{
    /**
     * Mailjet client
     * @var \Mailjet\Client
     */
    protected $mailjet;

    public function __construct(\Mailjet\Client $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * create a new fresh Contact to listId
     */
    public function create($listId, Contact $contact, $action=Contact::ACTION_ADDFORCE)
    {
        $contact->setAction($action);
        $response = $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactManager:create() failed:", $response);
        }

        return $reponse->getData();
    }

    /**
     * update a Contact to listId
     */
    public function update($listId, Contact $contact, $action=Contact::ACTION_ADDNOFORCE)
    {
        $contact->setAction($action);
        $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactManager:update() failed:", $response);
        }

        return $reponse->getData();
    }

    /**
     * re/subscribe a Contact to listId
     */
    public function subscribe($listId, Contact $contact)
    {
        $contact->setAction(Contact::ACTION_ADDFORCE);
        $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactManager:sub() failed:", $response);
        }

        return $reponse->getData();
    }

    /**
     * unsubscribe a Contact from listId
     */
    public function unsubscribe($listId, Contact $contact)
    {
        $contact->setAction(Contact::ACTION_UNSUB);
        $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactManager:unsub() failed:", $response);
        }

        return $reponse->getData();
    }

    /**
     * Delete a Contact from listId
     */
    public function delete($listId, Contact $contact)
    {
        $contact->setAction(Contact::ACTION_REMOVE);
        $this->_exec($listId, $contact);
        if (!$response->success()) {
            $this->throwError("ContactManager:remove() failed:", $response);
        }

        return $reponse->getData();
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

    private function throwError($title, $response)
    {
        throw new \RuntimeException($title.": ".$response->getData['StatusCode']." - ".$response->getData['ErrorInfo']." - ".$response->getData['ErrorMessage']);
    }
}
