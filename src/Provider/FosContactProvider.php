<?php

namespace Welp\MailjetBundle\Provider;

use Welp\MailjetBundle\Provider\ProviderInterface;
use Welp\MailjetBundle\Model\Contact;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\User;

class FosContactProvider implements ProviderInterface
{

    const PROP_ENABLED = 'enabled';
    const PROP_LAST_LOGIN = 'lastlogin';

    protected $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function getSubscribers()
    {
        $users = $this->userManager->findUsers();
        // or find only enabled users :
        // $users = $this->userManager->findUserBy(array('enabled' => true));

        $contacts = array_map(function(User $user) {
            $userProperties = [
                self::PROP_ENABLED => $user->isEnabled(),
                self::PROP_LAST_LOGIN => $user->getLastLogin() ? $user->getLastLogin()->format('Y-m-d') : null
            ];

            $contact = new Contact($user->getEmail(), $user->getUsername(), $userProperties);

            return $contact;
        }, $users);

        return $contacts;
    }
}
