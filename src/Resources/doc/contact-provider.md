# Contact Provider

After [configuring your lists](configuration.md) in `config.yml`, you need to create at least one `Provider` that will be used by the SyncUser command.
Your provider should be accessible via a service key (the same you reference in `contact_provider` in your configuration file):

```yaml
    services:
        yourapp.mailjet.contact_provider1:
            class: YourApp\AppBundle\Mailjet\MyContactProvider
            arguments: [@yourapp.user.repository]
```

You provider class should implement `Mailjet\MailjetBundle\Provider\ProviderInterface` and the method `getContacts` must return an array of `Mailjet\MailjetBundle\Model\Contact` objects.

## Example

Here is an example of ContactProvider:

```php
<?php

namespace YourApp\App\Mailjet;

use Mailjet\MailjetBundle\Provider\ProviderInterface;
use Mailjet\MailjetBundle\Model\Contact;

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
```

## FosContactProvider

We also provide a ready to use provider for FosUserBundle: `FosContactProvider`. You just need to register the service into your app:

```yaml
    services:
        yourapp.mailjet.fos_contact_provider:
            class: Mailjet\MailjetBundle\Provider\FosContactProvider
            arguments: [@fos_user.user_manager]
```

After this, don't forget to add the service key for your list into your `config.yml`:

```yaml
    ...
    listId1:
        contact_provider: 'yourapp.mailjet.fos_contact_provider'
```

Note: You need to have `enabled` and `lastlogin` in your contact properties
