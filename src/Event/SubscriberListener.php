<?php

namespace Welp\MailjetBundle\Event;

use Welp\MailjetBundle\Subscriber\ListRepository;
use Welp\MailjetBundle\Event\SubscriberEvent;

class SubscriberListener
{
    protected $listRepository;

    public function __construct(ListRepository $listRepository)
    {
        $this->listRepository = $listRepository;
    }

    public function onSubscribe(SubscriberEvent $event)
    {
        $this->listRepository->subscribe(
            $event->getListId(),
            $event->getSubscriber()
        );
    }

    public function onUnsubscribe(SubscriberEvent $event)
    {
        $this->listRepository->unsubscribe(
            $event->getListId(),
            $event->getSubscriber()
        );
    }

    public function onUpdate(SubscriberEvent $event)
    {
        $this->listRepository->update(
            $event->getListId(),
            $event->getSubscriber()
        );
    }

    public function onChangeEmail(SubscriberEvent $event)
    {
        $this->listRepository->changeEmailAddress(
            $event->getListId(),
            $event->getSubscriber(),
            $event->getOldEmail()
        );
    }

    public function onDelete(SubscriberEvent $event)
    {
        $this->listRepository->delete(
            $event->getListId(),
            $event->getSubscriber()
        );
    }
}
