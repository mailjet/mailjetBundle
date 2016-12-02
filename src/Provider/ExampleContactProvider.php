<?php

namespace YourApp\App\Newsletter;

use Welp\MailjetBundle\Provider\ProviderInterface;
use Welp\MailjetBundle\Subscriber\Subscriber;
use YourApp\Model\User\UserRepository;
use YourApp\Model\User\User;

class ExampleContactProvider implements ProviderInterface
{

    const PROP_NICKNAME =           'nickname';
    const PROP_GENDER =             'gender';
    const PROP_BIRTHDATE =          'birthdate';
    const PROP_LAST_ACTIVITY_DATE = 'last_activity';
    const PROP_REGISTRATION_DATE =  'registration_date';
    const PROP_CITY =               'city';

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getSubscribers()
    {
        $users = $this->userRepository->findUsers();

        $contacts = array_map(function(User $user) {
            $userProperties = [
                self::PROP_NICKNAME => $user->getNickname(),
                self::PROP_GENDER => $user->getGender(),
                self::PROP_BIRTHDATE => $user->getBirthday() ? $user->getBirthday()->format('Y-m-d') : null,
                self::PROP_LAST_ACTIVITY_DATE => $user->getLastActivity() ? $user->getLastActivity()->format('Y-m-d') : null
            ];

            $contact = new Contact($user->getEmail(), $user->getUsername(), $userProperties);

            return $contact;
        }, $users);

        return $contacts;
    }
}
