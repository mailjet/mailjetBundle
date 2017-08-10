# Mailjet Bundle

[![Build Status](https://travis-ci.org/mailjet/mailjetBundle.svg?branch=master)](https://travis-ci.org/mailjet/mailjetBundle)
[![Packagist](https://img.shields.io/packagist/v/mailjet/mailjet-bundle.svg)](https://packagist.org/packages/mailjet/mailjet-bundle)
[![Packagist](https://img.shields.io/packagist/dt/mailjet/mailjet-bundle.svg)](https://packagist.org/packages/mailjet/mailjet-bundle)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/mailjet/mailjetBundle/blob/master/LICENSE.md)
[![Documentation](https://img.shields.io/badge/documentation-gh--pages-blue.svg)](https://mailjet.github.io/mailjetBundle/)

Symfony bundle for handling Mailjet API V3 using this wrapper: <https://github.com/mailjet/mailjet-apiv3-php>

## Features

* [x] Retrieve [\Mailjet\Client](https://github.com/mailjet/mailjet-apiv3-php) to make custom Mailjet API V3 requests
* [x] [SwiftMailer Transport integration](https://github.com/mailjet/MailjetSwiftMailer)
* [x] Synchronize Contact Metadata (Contact Properties) with your config
* [x] Synchronize your user with Mailjet contact list
* [x] Use your own userProvider (basic `FosContactProvider` included to interface with FosUserBundle)
* [x] Use lifecycle event to subscribe/unsubscribe/update/delete/changeEmail user from a contact List
* [x] Register Event API - real time notifications (webhook)
* [x] Manage Campaigns,Campaigndrafts and Templates

## Setup

Add bundle to your project:

```bash
composer require mailjet/mailjet-bundle
```

Add `Mailjet\MailjetBundle\MailjetBundle` to your `AppKernel.php`:

```php
$bundles = [
    // ...
    new Mailjet\MailjetBundle\MailjetBundle(),
];
```

## Minimal Configuration

In your `config.yml`:

```yaml
mailjet:
    api_key:    "%mailjet.api_key%"
    secret_key: "%mailjet.secret_key%"
```

## ToDo

* More unit tests
* Functionnal tests
* Other features like Campaigns, stats, ...


## Contributing

If you want to contribute to this project, look at [over here](CONTRIBUTING.md)
