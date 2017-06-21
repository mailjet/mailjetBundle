<?php
namespace Mailjet\MailjetBundle\Client;

use Mailjet\Client;
use Mailjet\Response;

class MailjetClient extends Client
{
    protected $calls = [];
    /**
     * Trigger a POST request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function post($resource, array $args = [], array $options = [])
    {
        $response = parent::post($resource, $args, $options);
        $this->calls[] = [
            'method' => 'POST',
            'resource' => $resource,
            'args' => $args,
            'options' => $options,
            'success' => $response->success(),
            'response' => $response->getBody(),
        ];
        return $response;
    }
    /**
     * Trigger a GET request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function get($resource, array $args = [], array $options = [])
    {
        $response = parent::get($resource, $args, $options);
        $this->calls[] = [
            'method' => 'GET',
            'resource' => $resource,
            'args' => $args,
            'options' => $options,
            'success' => $response->success(),
            'response' => $response->getBody(),
        ];
        return $response;
    }
    /**
     * Trigger a POST request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function put($resource, array $args = [], array $options = [])
    {
        $response = parent::put($resource, $args, $options);
        $this->calls[] = [
            'method' => 'PUT',
            'resource' => $resource,
            'args' => $args,
            'options' => $options,
            'success' => $response->success(),
            'response' => $response->getBody(),
        ];
        return $response;
    }
    /**
     * Trigger a GET request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function delete($resource, array $args = [], array $options = [])
    {
        $response = parent::delete($resource, $args, $options);
        $this->calls[] = [
            'method' => 'DELETE',
            'resource' => $resource,
            'args' => $args,
            'options' => $options,
            'success' => $response->success(),
            'response' => $response->getBody(),
        ];
        return $response;
    }
    /**
     * @return array
     */
    public function getCalls()
    {
        return $this->calls;
    }
}
