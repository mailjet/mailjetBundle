<?php

namespace YourApp\App\Mailjet;

use Mailjet\MailjetBundle\Provider\ProviderInterface;

use YourApp\Model\User\UserRepository;
use YourApp\Model\User\User;

class ExampleContactProvider implements ProviderInterface
{

    const PROP_NICKNAME =           'nickname';
    const PROP_GENDER =             'gender';
    const PROP_CITY =               'city';
    const PROP_BIRTHDATE =          'birthdate';
    const PROP_LAST_ACTIVITY_DATE = 'last_activity';
    const PROP_REGISTRATION_DATE =  'registration_date';

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getContacts()
    {
        $users = $this->userRepository->findUsers();

        $contacts = array_map(function(User $user) {
            $userProperties = [
                self::PROP_NICKNAME => $user->getNickname(),
                self::PROP_GENDER => $user->getGender(),
                self::PROP_CITY => $user->getCity(),
                self::PROP_BIRTHDATE => $user->getBirthday() ? $user->getBirthday()->format('Y-m-d') : '',
                self::PROP_LAST_ACTIVITY_DATE => $user->getLastActivity() ? $user->getLastActivity()->format('Y-m-d') : ''
                self::PROP_REGISTRATION_DATE => $user->getRegistrateAt() ? $user->getRegistrateAt()->format('Y-m-d') : ''
            ];

            $contact = new Contact($user->getEmail(), $user->getUsername(), $userProperties);

            return $contact;
        }, $users);

        return $contacts;
    }
}
