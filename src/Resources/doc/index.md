# Mailjet Bundle

[![Build Status](https://travis-ci.org/welpdev/mailjetBundle.svg?branch=master)](https://travis-ci.org/welpdev/mailjetBundle)
[![Packagist](https://img.shields.io/packagist/v/welp/mailjet-bundle.svg)](https://packagist.org/packages/welp/mailjet-bundle)
[![Packagist](https://img.shields.io/packagist/dt/welp/mailjet-bundle.svg)](https://packagist.org/packages/welp/mailjet-bundle)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/welpdev/mailjetBundle/blob/master/LICENSE.md)
[![Documentation](https://img.shields.io/badge/documentation-gh--pages-blue.svg)](https://welpdev.github.io/mailjetBundle/)

Symfony bundle for handling Mailjet API V3 using this wrapper: <https://github.com/mailjet/mailjet-apiv3-php>

🚧 **WORK IN PROGRESS...** 🚧

## Features

* [x] Retrieve [\Mailjet\Client](https://github.com/mailjet/mailjet-apiv3-php) to make custom Mailjet API V3 requests
* [x] [SwiftMailer Transport integration](https://github.com/welpdev/MailjetSwiftMailer)
* [x] Synchronize Contact Metadata (Contact Properties) with your config
* [x] Synchronize your user with MailJet contact list
* [x] Use your own userProvider (basic `FosContactProvider` included to interface with FosUserBundle)
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
* Unit Synchronize User
* Debug/Sandbox configuration mode

## MailJet issues

* How to change user email? (workaround: remove old, add new...)
* Event API/webhook: how to synchronize specific contact subscribe event ? (available sent, open, click, bounce, spam, blocked, unsub)
    - When user unsubscribe from external link ??
    - When user resubscribe to list (widget or admin)


## Contributing

If you want to contribute to this project, look at [over here](CONTRIBUTING.md)
