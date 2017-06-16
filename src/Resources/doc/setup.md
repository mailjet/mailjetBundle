# Setup

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

[More configuration](configuration.md)
