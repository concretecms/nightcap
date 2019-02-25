<?php
namespace Concrete\Nightcap\Service;

use Concrete\Nightcap\Service\Description\DescriptionInterface;

/**
 * Holds objects of the Concrete\Nightcap\Service\Description\DescriptionInterface variety for use with the
 * API client.
 * Class ServiceCollection
 * @package PortlandLabs\LibertaServer\Api\Client\Service
 */
class ServiceCollection
{

    /**
     * @var DescriptionInterface[]
     */
    protected $descriptions = [];

    public function add(DescriptionInterface $description)
    {
        $this->descriptions[$description->getNamespace()] = $description;
    }

    public function get($namespace)
    {
        return $this->descriptions[$namespace];
    }

    public function toArray()
    {
        return $this->descriptions;
    }


}