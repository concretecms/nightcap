<?php
namespace Concrete\Api\Client\Provider;

class BasicProvider implements ProviderInterface
{

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var array
     */
    protected $config = [];

    public function __construct($baseUrl, $config = [])
    {
        $this->baseUrl = $baseUrl;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }



}