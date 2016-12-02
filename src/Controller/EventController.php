<?php
namespace Welp\MailjetBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/mailjet-event")
 */
class EventController
{

    /**
     * Endpoint for the mailjet events (webhooks)
     * https://dev.mailjet.com/guides/#events
     * https://live-event-dashboard-demo.mailjet.com/
     * @Route("/endpoint", name="welp_mailjet_event_endpoint")
     * @Method({"POST"})
     */
    public function indexAction(Request $request)
    {
        if ($this->token !== $token) {
            return false;
        }

        $data = $this->extractData($request);
        //$event = $this->eventFactory->createEvent($data);
        /*
            Please note that the event types in the collection can be mixed.
            We group together all the events of the last second for the same webhook url.
        */
        //$this->eventDispatcher->dispatch($event->getType(), $event);

    }

    private function extractData(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

    private function prepareResponse($status)
    {
        return new JsonResponse(array(), $status);
    }
}
