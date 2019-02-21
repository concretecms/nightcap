<?php
namespace Concrete\Api\Client\Service;

use Concrete\Api\Client\Service\Description\DescriptionInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\Description;

class ServiceDescriptionFactory
{

    public function createServiceDescription(Client $httpClient, DescriptionInterface $description)
    {
        $descriptionData = $description->getDescription();
        $baseUrl = $httpClient->getConfig('base_uri');
        $descriptionData['baseUrl'] = $baseUrl;
        $serviceDescription = new Description($descriptionData);
        return $serviceDescription;
    }




}