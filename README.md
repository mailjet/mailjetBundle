# MailJet Bundle
Symfony bundle for handling Mailjet API V3

** /!\ WORK IN PROGRESS... NOT READY TO USE /!\ Wait for a release before using it.**

## Features

* [x] Retrieve [\Mailjet\Client](https://github.com/mailjet/mailjet-apiv3-php) to make custom MailJet API V3 requests
* [ ] Synchronize your user with MailJet contact list
* [x] Use your own userProvider (basic `FosContactProvider` included to interface with FosUserBundle)
* [ ] Use lifecycle event to subscribe/unsubscribe/update/delete user from a contact List
* [ ] Register Event API - real time notifications (webhook)

## Setup

Add bundle to your project:

```bash
composer require welp/mailjet-bundle
```

Add `Welp\MailjetBundle\WelpMailjetBundle` to your `AppKernel.php`:

```php
$bundles = [
    // ...
    new Welp\MailjetBundle\WelpMailjetBundle(),
];
```

## Minimal Configuration

In your `config.yml`:

```yaml
welp_mailjet:
    api_key:    "%mailjet_api_key%"
    secret_key: "%mailjet_secret_key%"
```

## ToDo

* Moar tests...
