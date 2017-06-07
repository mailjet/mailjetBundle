<?php

namespace Welp\MailjetBundle\Service;

use \Mailjet\Resources;

use Welp\MailjetBundle\Model\EventCallbackUrl;

/**
* https://dev.mailjet.com/email-api/v3/eventcallbackurl/
* Manage EventCallbackUrl
*/
class EventCallbackUrlManager
{

    /**
     * Mailjet client
     * @var \Mailjet\Client
     */
    protected $mailjet;

    /**
     * @param \Mailjet\Client $mailjet
     */
    public function __construct(\Mailjet\Client $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * Retrieve all EventCallbackUrl
     * @return array
     */
    public function getAll()
    {
        $response = $this->mailjet->get(Resources::$Eventcallbackurl);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlManager:getAll() failed:", $response);
        }

        return $reponse->getData();
    }

    /**
     * Retrieve one EventCallbackUrl
     * @param string $id
     * @return array
     */
    public function get($id)
    {
        $response = $this->mailjet->get(Resources::$Eventcallbackurl, ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlManager:get() failed:", $response);
        }

        return $reponse->getData();
    }

    /**
     * Create one EventCallbackUrl
     * @param EventCallbackUrl $eventCallbackUrl
     * @return array
     */
    public function create(EventCallbackUrl $eventCallbackUrl)
    {
        $response = $this->mailjet->post(Resources::$Eventcallbackurl, ['body' => $eventCallbackUrl->format()]);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlManager:create() failed:", $response);
        }

        return $reponse->getData();
    }

    /**
     * Update one EventCallbackUrl
     * @param string $id
     * @param EventCallbackUrl $eventCallbackUrl
     * @return array
     */
    public function update($id, EventCallbackUrl $eventCallbackUrl)
    {
        $response = $this->mailjet->put(Resources::$Eventcallbackurl, ['id' => $id, 'body' => $eventCallbackUrl->format()]);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlManager:update() failed:", $response);
        }

        return $reponse->getData();
    }

    /**
     * Delete one EventCallbackUrl
     * @param string $id
     * @return array
     */
    public function delete($id)
    {
        $response = $this->mailjet->delete(Resources::$Eventcallbackurl, ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlManager:delete() failed:", $response);
        }

        return $reponse->getData();
    }

    /**
     * Helper to throw error
     * @param  string $title
     * @param  array $response
     */
    private function throwError($title, $response)
    {
        throw new \RuntimeException($title.": ".$response->getData['StatusCode']." - ".$response->getData['ErrorInfo']." - ".$response->getData['ErrorMessage']);
    }
}
