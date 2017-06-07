<?php

namespace Welp\MailjetBundle\Service;

use \Mailjet\Resources;

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
     * Retrieve EventCallbackUrl
     * @return array
     */
    public function get()
    {
        $response = $this->mailjet->post(Resources::$Eventcallbackurl);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlManager:get() failed:", $response);
        }

        return $reponse->getData();
    }

    /**
     * Retrieve all EventCallbackUrl
     * @return array
     */
    public function getAll()
    {
        $response = $this->mailjet->get(Resources::$Eventcallbackurl);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlManager:get() failed:", $response);
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
     * Helper to throw error
     * @param  string $title
     * @param  array $response
     */
    private function throwError($title, $response)
    {
        throw new \RuntimeException($title.": ".$response->getData['StatusCode']." - ".$response->getData['ErrorInfo']." - ".$response->getData['ErrorMessage']);
    }
}
