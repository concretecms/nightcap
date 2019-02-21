<?php
namespace Concrete\Api\Client;

use Concrete\Api\Client\Service\Description\DescriptionInterface;
use Concrete\Api\Client\Service\ServiceCollection;
use GuzzleHttp\Command\Guzzle\Description;

class Client
{

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var ServiceClientFactory
     */
    protected $serviceClientFactory;

    /**
     * @var ServiceCollection
     */
    protected $serviceCollection;

    /**
     * @var DescriptionInterface[]
     */
    protected $descriptions = [];

    public function __construct(
        \GuzzleHttp\Client $httpClient,
        ServiceCollection $serviceCollection,
        ServiceClientFactory $serviceClientFactory)
    {
        $this->httpClient = $httpClient;
        $this->serviceCollection = $serviceCollection;
        $this->serviceClientFactory = $serviceClientFactory;
    }

    public function getWebServiceClient($name)
    {
        return $this->serviceClientFactory->createServiceClient(
            $this->httpClient,
            $this->getServiceDescription($name)
        );
    }

    public function addServiceDescription(DescriptionInterface $description)
    {
        $this->serviceCollection->add($description->getNamespace(), $description);
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
        return $this->serviceCollection->toArray();
    }

    protected function getServiceDescription($namespace)
    {
        /**
         * @var DescriptionInterface $description
         */
        $description = $this->serviceCollection->get($namespace);
        $descriptionData = $description->getDescription();

        $baseUrl = $this->httpClient->getConfig('base_uri');
        $descriptionData['baseUrl'] = $baseUrl;

        return new Description($descriptionData);
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