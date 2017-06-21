# Event API: real-time notifications (webhook)

* [Mailjet Dev guide](https://dev.mailjet.com/guides/#event-api-real-time-notifications)
* [Mailjet Event Config](https://app.mailjet.com/account/triggers)

## Configuration

You need to add the webhook routing to your app routing:

`app/routing.yml`

```yaml
# Mailjet webhook route
myapp_mailjet_webhook:
    resource: "@MailjetBundle/Resources/config/routing.yml"
    prefix:   /mailjet
```

Note: you can change the prefix as you like.

This will generate an url to the webhook like this: http://domain.com/mailjet/mailjet-event/endpoint

Also, Mailjet recommand to protect webhook url with a token parameter. So you need to add the secret token to your list in your config.yml

config.yml

```yaml
mailjet:
    api_key:    "%mailjet.api_key%"
    secret_key: "%mailjet.api_secret%"
    ...
    event_endpoint_token: "thisisTheSecretPass"
```

Note: To access properly to the webhook function you will have to use the url with the secret parameter: <http://domain.com/mailjet/mailjet-event/endpoint/thisisTheSecretPass>

## Register callback urls manually

You can set up manually through the Mailjet panel: [here](https://app.mailjet.com/account/triggers)

You need to add the correct callback url such as: <http://domain.com/mailjet/mailjet-event/endpoint/thisisTheSecretPass>

## Command to automatically register callback Urls

You can use the Symfony command to automatically register callback Urls:

```shell
php app/console mailjet:event-endpoint http://domain.com
```

By default, this command will register the url to al event Type. You can specify type as options if you want to register to specific event type:

```shell
php app/console mailjet:event-endpoint http://domain.com --event-type=open --event-type=unsub
```

Event type list: `["sent", "open", "click", "bounce", "blocked", "spam", "unsub"]`

## Events to listen
In order to integrate MailChimp into your app workflow, you can listen to different Event.

Event you can listen:

```php
CallbackEvent::EVENT_SENT = 'mailjet.event.sent';
CallbackEvent::EVENT_OPEN = 'mailjet.event.open';
CallbackEvent::EVENT_CLICK = 'mailjet.event.click';
CallbackEvent::EVENT_BOUNCE = 'mailjet.event.bounce';
CallbackEvent::EVENT_SPAM = 'mailjet.event.spam';
CallbackEvent::EVENT_BLOCKED = 'mailjet.event.blocked';
CallbackEvent::EVENT_UNSUB = 'mailjet.event.unsub';
```

### 1- create an Event Listener

```php
<?php

namespace AppBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Mailjet\MailjetBundle\Event\CallbackEvent;

class MailjetEventListener implements EventSubscriberInterface
{

    protected $logger;


    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            CallbackEvent::EVENT_SENT => 'sent',
            CallbackEvent::EVENT_OPEN => 'open',
            CallbackEvent::EVENT_CLICK => 'click',
            CallbackEvent::EVENT_BOUNCE => 'bounce',
            CallbackEvent::EVENT_SPAM => 'spam',
            CallbackEvent::EVENT_BLOCKED => 'blocked',
            CallbackEvent::EVENT_UNSUB => 'unsub'

        ];
    }

    public function sent(CallbackEvent $event){
        $this->logger->info('sent Event:', $event->getData());
    }

    public function open(CallbackEvent $event){
        $this->logger->info('open Event:', $event->getData());
    }

    public function click(CallbackEvent $event){
        $this->logger->info('click Event:', $event->getData());
    }

    public function bounce(CallbackEvent $event){
        $this->logger->info('bounce Event:', $event->getData());
    }

    public function spam(CallbackEvent $event){
        $this->logger->info('spam Event:', $event->getData());
    }

    public function blocked(CallbackEvent $event){
        $this->logger->info('blocked Event:', $event->getData());
    }

    public function unsub(CallbackEvent $event){
        $this->logger->info('unsub Event:', $event->getData());
    }

}
```

### 2- Register the listener into services.yml

```yaml
services:
    app.listener.mailjet.webhook:
        class: AppBundle\Listener\MailjetEventListener
        tags:
            - { name: kernel.event_subscriber }
        arguments:
            - @logger
```

### 3- Test with ngrok (or other localhost tunnel)
