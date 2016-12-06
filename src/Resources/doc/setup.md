# Setup

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

[More configuration](configuration.md)
