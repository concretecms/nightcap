<?php
namespace Concrete\Api\Client\OAuth2\Configuration\Traits;

trait ClientIdTrait
{

    protected $clientId;

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

}