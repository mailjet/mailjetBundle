# Usage

## Synchronize Contact Metadata (Contact Properties)

Contact Metadata (or Contact Properties) are values you can add to your contacts (for example firstname, birthdate, isenabled, ...).
You can use these metadata in your newsletters or to create segments out of them.

This bundle provides a simple way to configure and synchronize these metadata with your Mailjet account.

You just need to configure in your config.yml your `contact_metadata`: [see the configuration](configuration.md).

Finally, you can use this command to synchronize your config with Mailjet:

    php app/console mailjet:contactmetadata-sync


## Full synchronization with command

You can synchronize all users of your project with a Mailjet list at once by calling the Symfony command:

    php app/console mailjet:user-sync


It will get all your User throught your Contact Provider and will add/update all your User to the configured list.

You can use the option `--follow-sync` to supervise batch jobs.

    php app/console mailjet:user-sync --follow-sync

NOTE: you must have configured and created [your own contact provider](contact-provider.md).

## Unit synchronization with events

If you want realtime synchronization, you can dispatch custom events on your controllers/managers (or anywhere). The subscribe event can be used both for adding a new contact or updating an existing one. You can fired these events to trigger sync with Mailjet:

```php
    ContactEvent::EVENT_SUBSCRIBE = 'mailjet.mailjet.subscribe';
    ContactEvent::EVENT_UNSUBSCRIBE = 'mailjet.mailjet.unsubscribe';
    ContactEvent::EVENT_UPDATE = 'mailjet.mailjet.update';
    ContactEvent::EVENT_DELETE = 'mailjet.mailjet.delete';
    // NOT IMPLETENTED YET // ContactEvent::EVENT_CHANGE_EMAIL = 'mailjet.mailjet.change_email';
```

### Subscribe new User

Here is an example of a subscribe event dispatch:

```php
<?php

use Mailjet\MailjetBundle\Event\ContactEvent;
use Mailjet\MailjetBundle\Model\Contact;

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

use Mailjet\MailjetBundle\Event\ContactEvent;
use Mailjet\MailjetBundle\Model\Contact;

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

use Mailjet\MailjetBundle\Event\ContactEvent;
use Mailjet\MailjetBundle\Model\Contact;

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

use Mailjet\MailjetBundle\Event\ContactEvent;
use Mailjet\MailjetBundle\Model\Contact;

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

```php
<?php

use Mailjet\MailjetBundle\Event\ContactEvent;
use Mailjet\MailjetBundle\Model\Contact;

public function changeEmailAddress($oldEmail, $newEmail)
{
    // ...
    $contact = new Contact($newEmail);

    $this->container->get('event_dispatcher')->dispatch(
        ContactEvent::EVENT_CHANGE_EMAIL,
        new ContactEvent('your_list_id', $contact, $oldEmail)
    );

}
```

WORKAROUND: remove old, add new

## Retrieve Mailjet Client Object to make custom MailJet API V3 requests

You can also retrieve the MailJet Client Object which comes from the wrapper [mailjet/mailjet-apiv3-php](https://github.com/mailjet/mailjet-apiv3-php).

The service key is `mailjet.client`.

Example:

``` php
<?php
    use \Mailjet\Resources;

    // in any controller action...
    ...
    $mailjet = $this->container->get('mailjet.client');

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
    // Send transactional emails (note: prefer using SwiftMailer to send transactionnal emails)

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
## Campaigndraft Example

You can also access the [/campaigndraft](https://dev.mailjet.com/email-api/v3/campaigndraft) api through the CampaignDraftManager 

Example:

``` php
<?php
use \Mailjet\Resources;
use Mailjet\MailjetBundle\Model\CampaignDraft;
use Mailjet\MailjetBundle\Manager\CampaignDraftManager;
// ...
public function campaignDraftExample() {
    // ...
    $campaignDraftManager = $this->container->get('mailjet.service.campaign_draft_manager');
    $optionalProp['Title'] = 'Friday newsletter';
    $optionalProp['SenderName'] = 'Mailjet team';
    $optionalProp['EditMode'] = 'html2';
    $campaignDraft = new CampaignDraft("en_US", "Lyubo", "api@mailjet.com", "Symfony bundle test", "5410");
    $campaignDraft->setOptionalProperties($optionalProp);
    $ID = $campaignDraftManager->create($campaignDraft)[0]['ID'];

    /*     * Get the ID from the newly created CampaignDraft* */
    $campaignDraft->setId($ID);
    /*     * Set and create content** */
    $content = ['Html-part' => "Hello <strong>world</strong>!",
        'Text-part' => "Hello world!"];
    $campaignDraft->setContent($content);
    $campaignDraftManager->createDetailContent($campaignDraft->getId(), $campaignDraft->getContent());
      /*     * Send a campaigndraft** */
    $campaignDraftManager->sendCampaign($campaignDraft->getId());
}
```
## Template Example

You can also access the [/template](https://dev.mailjet.com/email-api/v3/template) api through the TemplateManager 

Example:

``` php
<?php
use \Mailjet\Resources;
use Mailjet\MailjetBundle\Model\Template;
use Mailjet\MailjetBundle\Manager\TemplateManager;

// ...
public function templateExample() {
    // ...
        //Example create template
        $templateManager = $this->container->get('mailjet.service.template_manager');
        $optionalProp['Author'] = 'Mailjet team';
        $optionalProp['EditMode'] = 1;
        $optionalProp['Purposes'] = ['transactional'];
        $template = new Template("Symfony Template Example!!! ", $optionalProp);
        
        $ID = $templateManager->create($template)[0]['ID'];
        
        //Add content to a template
        $contentData = [
            'Html-part' => "<html><body><p>Hello {{var:name}}</p></body></html>",
            'Text-part' => "Hello {{var:name}}"
        ];
        $templateManager->createDetailContent($ID, $contentData);
        
        //Example list all templates based on multiple filters
        $filters['OwnerType']='apikey';
        $filters['EditMode']=1;
        $result=$templateManager->getAll($filters);
}
```
## Campaigns Example

You can also access the [/campaign](https://dev.mailjet.com/email-api/v3/campaign) api through the CampaignManager 

Example:

``` php
<?php
use \Mailjet\Resources;
use Mailjet\MailjetBundle\Model\Campaign;
use Mailjet\MailjetBundle\Manager\CampaignManager;
    // ...
public function campaignExample() {
        // ...
        //Example retrieve all (limit 10 :) ) stared campaigns
        $campaignManager = $this->container->get('mailjet.service.campaign_manager');
        $filters['IsStarred']=true;
        $result = $campaignManager->getAllCampaigns($filters);
}
```
