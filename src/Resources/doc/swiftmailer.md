# Mailjet SwiftMailer Transport

## Configuration

```yaml
    # Swiftmailer Configuration
    swiftmailer:
        transport: mailjet
```

## Send email example

```php
$message = \Swift_Message::newInstance()
    ->setSubject('this is and email')
    ->setFrom(['no-reply@foo.bar' => 'Transactionnal'])
    ->setTo('to@foo.bar')
    ->setBody(
        '<strong>hello world!</strong>',
        'text/html'
    );

//Configure Headers
$headers = $message->getHeaders();
// Mailjet header
$headers->addTextHeader('X-MJ-CustomID', $this->getName());

// send email
$this->get('mailer')->send($message);

```

## Documentation

[MailjetSwiftMailer github](https://github.com/mailjet/MailjetSwiftMailer)
