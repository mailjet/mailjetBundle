<?php

namespace Welp\MailjetBundle\Model;

/**
* https://dev.mailjet.com/email-api/v3/contactslist-managecontact/
* Only email is required
*/
class Contact
{

    const EMAIL_KEY = 'Email';
    const NAME_KEY = 'Name';
    const PROPERTIES_KEY = 'Properties';

    protected $email;
    protected $name;
    protected $properties;

    public function __construct($email, $name = null, array $properties = [])
    {
        $this->email = $email;
        $this->name = $name;
        $this->properties = $properties;
    }

    /**
     * Formate contact for MailJet API request
     * @return array
     */
    public function format(){
        $result = [
            self::EMAIL_KEY => $this->email,
        ];

        if(!is_null($this->name))
            $result[self::NAME_KEY] = $this->name;

        if(!is_null($this->properties))
            $result[self::PROPERTIES_KEY] = $this->properties;

        return $result;
    }

    /**
     * Correspond to Email in MailJet request
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Correspond to Name in MailJet request
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Correspond to Properties in MailJet request
     * Array ['property' => value, ...]
     */
    public function getProperties()
    {
        return $this->properties;
    }

}
