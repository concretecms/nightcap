<?php
namespace Concrete\Api\Client\OAuth2\Authorization;

use Concrete\Api\Client\ClientFactory;
use Concrete\Api\Client\OAuth2\Authorization\Redirect\RedirectorInterface;
use Concrete\Api\Client\OAuth2\Authorization\StateStore\StateStoreInterface;
use Concrete\Api\Client\OAuth2\Configuration\AuthorizationCodeConfiguration;
use Concrete\Api\Client\OAuth2\Exception\InvalidGrantTypeException;
use Concrete\Api\Client\OAuth2\Exception\InvalidStateException;
use Concrete\OAuth2\Client\Provider\Concrete5ResourceOwner;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use League\OAuth2\Client\Provider\AbstractProvider;

class ClientAuthorizer
{

    /**
     * @var AbstractProvider
     */
    protected $oauthProvider;

    /**
     * @var TokenPersistenceInterface
     */
    protected $tokenStore;

    /**
     * @var StateStoreInterface
     */
    protected $stateStore;

    /**
     * @var RedirectorInterface
     */
    protected $redirector;

    /**
     * @var ClientFactory
     */
    protected $clientFactory;

    public function __construct(
        AbstractProvider $oauthProvider,
        TokenPersistenceInterface $tokenStore,
        StateStoreInterface $stateStore,
        RedirectorInterface $redirector,
        ClientFactory $clientFactory)
    {
        $this->oauthProvider = $oauthProvider;
        $this->tokenStore = $tokenStore;
        $this->stateStore = $stateStore;
        $this->redirector = $redirector;
        $this->clientFactory = $clientFactory;
    }

    public function isClientAuthorized()
    {
        if ($this->tokenStore->hasToken()) {
            return true;
        }
        return false;
    }

    /**
     * @param array config - you can put additional scopes in here with ['scope' => 'system account etc']
     * @return mixed
     */
    public function redirectToAuthorizeUrl($config = [])
    {
        $authorizeUrl = $this->oauthProvider->getAuthorizationUrl($config);
        $this->stateStore->set($this->oauthProvider->getState());
        $this->tokenStore->deleteToken();
        return $this->redirector->redirect($authorizeUrl);

    }

    /**
     * Authorizes the client with the access code and the state retrieved from the authorization server.
     * Returns the resource owner.
     * @param $accessCode
     * @param $state
     * @return Concrete5ResourceOwner
     */
    public function authorizeClient($authCode, $state)
    {
        if (!$state || $state != $this->stateStore->get()) {
            throw new InvalidStateException(
                'OAuth2 state parameter empty or did not match what was retrieved from the state store.'
            );
        }

        // Now, let's grab the Authorization configuration object out of our client middleware, update the
        // access code within, and voila...
        $configuration = $this->clientFactory->getMiddlewareFactory()->getConfiguration();
        if (!$configuration instanceof AuthorizationCodeConfiguration) {
            throw new InvalidGrantTypeException(
                'Invalid grant type – only the Authorization Code Configuration object may be used with the authorizeClient method..'
            );
        }

        $configuration->setAuthCode($authCode);
        $client = $this->clientFactory->create();

        $result = $client->account()->getResourceOwner();
        if ($result) {
            $json = $result->toArray();
            return new Concrete5ResourceOwner($json);
        }
    }


}