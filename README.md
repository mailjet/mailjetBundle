# MailJet Bundle

[![Build Status](https://travis-ci.org/welpdev/mailjetBundle.svg?branch=master)](https://travis-ci.org/welpdev/mailjetBundle)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/welpdev/mailjetBundle/blob/master/LICENSE.md)
[![Documentation](https://img.shields.io/badge/documentation-gh--pages-blue.svg)](https://welpdev.github.io/mailjetBundle/)

Symfony bundle for handling Mailjet API V3 using this wrapper: <https://github.com/mailjet/mailjet-apiv3-php>

**/!\ WORK IN PROGRESS... NOT READY TO USE /!\ Wait for a release before using it.**

## Features

* [x] Retrieve [\Mailjet\Client](https://github.com/mailjet/mailjet-apiv3-php) to make custom MailJet API V3 requests
* [x] Synchronize your user with MailJet contact list *(need more tests)*
* [x] Use your own userProvider (basic `FosContactProvider` included to interface with FosUserBundle) *(need more tests)*
* [x] Use lifecycle event to subscribe/unsubscribe/update/delete user from a contact List *(need more tests)*
* [ ] Register Event API - real time notifications (webhook) *(need more tests)*

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
* handle when user changes email
* MANAGING LIST SUBSCRIPTIONS FOR A SINGLE CONTACT ( /CONTACT/$ID/MANAGECONTACTSLISTS )
* MANAGING AND UPLOADING MULTIPLE CONTACTS ( /CONTACT/MANAGEMANYCONTACTS )
* MANAGING CONTACTS THROUGH CSV UPLOAD

## MailJet issues

* How to change user email? (workaround: remove old, add new...)
* Event API/webhook: how to synchronize subscribe event from admin or form ith our app? (available sent, open, click, bounce, spam, blocked, unsub)
