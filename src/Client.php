<?php
namespace Concrete\Api\Client;

use Concrete\Api\Client\Service\DescriptionInterface;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient as WebServiceClient;

class Client
{

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var DescriptionInterface[]
     */
    protected $descriptions = [];

    public function __construct(\GuzzleHttp\Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getWebServiceClient($name)
    {
        return new WebServiceClient($this->httpClient, $this->getServiceDescription($name));
    }

    public function addServiceDescription(DescriptionInterface $description)
    {
        $this->descriptions[$description->getNamespace()] = $description->getDescription();
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient(): \GuzzleHttp\Client
    {
        return $this->httpClient;
    }

    /**
     * @return DescriptionInterface[]
     */
    public function getServiceDescriptions()
    {
        return $this->descriptions;
    }

    protected function getServiceDescription($namespace)
    {
        $baseUrl = $this->httpClient->getConfig('base_uri');
        $config = $this->descriptions[$namespace];
        $config['baseUrl'] = $baseUrl;
        return new Description($config);
    }

    public function system()
    {
        return $this->getWebServiceClient('system');
    }

    public function site()
    {
        return $this->getWebServiceClient('site');
    }

    public function account()
    {
        return $this->getWebServiceClient('account');
    }

    public function __call($name, $arguments)
    {
        // Handles dynamic parsing of the service client, allowing packages
        // to add to this via config.
        return $this->getWebServiceClient($name);
    }


}