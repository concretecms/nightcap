<?php
namespace Concrete\Api\Client\Provider;

use Concrete\Api\Client\Service\AuthorizationStateStoreInterface;
use Concrete\Api\Client\Service\DescriptionInterface;
use Concrete\OAuth2\Client\Provider\Concrete5;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface ProviderInterface
{

    /**
     * @return string
     */
    public function getClientId();

    /**
     * @return string
     */
    public function getClientSecret();

    /**
     * @return string
     */
    public function getRedirectUri();

    /**
     * @return string
     */
    public function getBaseUrl();

    /**
     * @return array
     */
    public function getClientConfig();


    /**
     * @return Concrete5
     */
    public function createAuthenticationProvider();

    /**
     * @return DescriptionInterface[]
     */
    public function getServiceDescriptions();

    /**
     * @return TokenPersistenceInterface
     */
    public function getTokenStore();

    /**
     * @return AuthorizationStateStoreInterface
     */
    public function getAuthorizationStateStore();

}