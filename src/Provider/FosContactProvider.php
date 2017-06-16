<?php

namespace Mailjet\MailjetBundle\Provider;

use Mailjet\MailjetBundle\Provider\ProviderInterface;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\User;

use Mailjet\MailjetBundle\Model\Contact;

class FosContactProvider implements ProviderInterface
{
    const PROP_ENABLED = 'enabled';
    const PROP_LAST_LOGIN = 'lastlogin';

    protected $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function getContacts()
    {
        $users = $this->userManager->findUsers();
        // or find only enabled users :
        // $users = $this->userManager->findUserBy(array('enabled' => true));

        $contacts = array_map(function (User $user) {
            $userProperties = [
                self::PROP_ENABLED => $user->isEnabled(),
                self::PROP_LAST_LOGIN => $user->getLastLogin() ? $user->getLastLogin()->format('Y-m-d') : ''
            ];

            $contact = new Contact($user->getEmail(), $user->getUsername(), $userProperties);

            return $contact;
        }, $users);

        return $contacts;
    }
}
