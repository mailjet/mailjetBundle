# Usage

## Full synchronization with command

You can synchronize all users of your project with a MailJet list at once by calling the Symfony command:

    php app/console welp:mailjet:user-sync


It will get all your User throught your Contact Provider and will add/update all your User to the configured list.

NOTE: you must have configured and created [your own contact provider](contact-provider.md).

## Unit synchronization with events

If you want realtime synchronization, you can dispatch custom events on your controllers/managers (or anywhere). The subscribe event can be used both for adding a new contact or updating an existing one. You can fired these events to trigger sync with MailJet:

    ContactEvent::EVENT_SUBSCRIBE = 'welp.mailjet.subscribe';
    ContactEvent::EVENT_UNSUBSCRIBE = 'welp.mailjet.unsubscribe';
    ContactEvent::EVENT_UPDATE = 'welp.mailjet.update';
    ContactEvent::EVENT_DELETE = 'welp.mailjet.delete';
    // NOT IMPLETENTED YET // ContactEvent::EVENT_CHANGE_EMAIL = 'welp.mailjet.change_email';

### Subscribe new User

Here is an example of a subscribe event dispatch:

```php
<?php

use Welp\MailjetBundle\Event\ContactEvent;
use Welp\MailjetBundle\Model\Contact;

// ...

public function newUser(User $user)
{
    // ...

    $contact = new Contact($user->getEmail(), $user->getNickname(), [
        'firstname' => $user->getFirstname(),
        'lastname' => $user->getLastname(),
        'city' => $user->getCity(),
        'language' => 'fr'
    ]);

	$this->container->get('event_dispatcher')->dispatch(
        ContactEvent::EVENT_SUBSCRIBE,
        new ContactEvent('your_list_id', $contact)
    );
}
```

### Unsubscribe a User

Unsubscribe is simpler, you only need the email:

```php
<?php

use Welp\MailjetBundle\Event\ContactEvent;
use Welp\MailjetBundle\Model\Contact;

// ...

public function unsubscribeUser(User $user)
{
    // ...

    $contact = new Contact($user->getEmail());

    $this->container->get('event_dispatcher')->dispatch(
        ContactEvent::EVENT_UNSUBSCRIBE,
        new ContactEvent('your_list_id', $contact)
    );
}
```

### Update a User

If your User changes his information, you can sync with MailChimp:

```php
<?php

use Welp\MailjetBundle\Event\ContactEvent;
use Welp\MailjetBundle\Model\Contact;

// ...

public function updateUser(User $user)
{
    // ...

    $contact = new Contact($user->getEmail(), $user->getNickname(), [
        'firstname' => $user->getFirstname(),
        'lastname' => $user->getLastname(),
        'city' => $user->getCity(),
        'language' => 'fr'
    ]);

    $this->container->get('event_dispatcher')->dispatch(
        ContactEvent::EVENT_UPDATE,
        new ContactEvent('your_list_id', $contact)
    );
}
```

Note: we can't change the address email of a user... MailJet API V3 doesn't permit it so far.


### Delete a User

And finally delete a User:


```php
<?php

use Welp\MailjetBundle\Event\ContactEvent;
use Welp\MailjetBundle\Model\Contact;

// ...

public function deleteUser(User $user)
{
    // ...

    $contact = new Contact($user->getEmail());

    $this->container->get('event_dispatcher')->dispatch(
        ContactEvent::EVENT_DELETE,
        new ContactEvent('your_list_id', $contact)
    );
}
```

### Change User's email address

NOT POSSIBLE YET...(WORKAROUND: remove old, add new)


## Retrieve MailJet Client Object to make custom MailJet API V3 requests

You can also retrieve the MailJet Client Object which comes from the wrapper [mailjet/mailjet-apiv3-php](https://github.com/mailjet/mailjet-apiv3-php).

The service key is `welp_mailjet.api`.

Example:

``` php
<?php
    use \Mailjet\Resources;
    
    // in any controller action...
    ...
    $mailjet = $this->container->get('welp_mailjet.api');

    // Resources are all located in the Resources class
    $response = $mailjet->get(Resources::$Contact);

    /*
      Read the response
    */
    if ($response->success())
      var_dump($response->getData());
    else
      var_dump($response->getStatus());

    ...
    // Send transactional emails

    $body = [
        'FromEmail' => "pilot@mailjet.com",
        'FromName' => "Mailjet Pilot",
        'Subject' => "Your email flight plan!",
        'Text-part' => "Dear passenger, welcome to Mailjet! May the delivery force be with you!",
        'Html-part' => "<h3>Dear passenger, welcome to Mailjet!</h3><br />May the delivery force be with you!",
        'Recipients' => [['Email' => "passenger@mailjet.com"]]
    ];

    $response = $mailjet->post(Resources::$Email, ['body' => $body]);

```
