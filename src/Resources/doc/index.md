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
* [x] Synchronize your user with Mailjet contact list
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

* More unit tests
* Functionnal tests
* handle when user changes email
* Bulletproof webhook handler
* Specific config for transactionnal client (call, options)
* Other features like Campaigns, stats, ...


## Contributing

If you want to contribute to this project, look at [over here](CONTRIBUTING.md)
