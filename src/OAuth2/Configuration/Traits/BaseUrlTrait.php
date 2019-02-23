<?php
namespace Concrete\Api\Client\OAuth2\Configuration\Traits;

trait BaseUrlTrait
{

    protected $baseUrl;

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param mixed $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }




}