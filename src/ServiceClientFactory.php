<?php
namespace Concrete\Nightcap;

use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient as WebServiceClient;

class ServiceClientFactory
{

    /**
     * Creates a web service client from the REST client we created within our client factory.
     * @param \GuzzleHttp\Client $httpClient
     * @param Description $description
     * @return WebServiceClient
     */
    public function createServiceClient(\GuzzleHttp\Client $httpClient, Description $description)
    {
        return new WebServiceClient($httpClient, $description);
    }


}