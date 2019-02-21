<?php
namespace Concrete\Api\Client;

use Concrete\Api\Client\OAuth2\Exception\InvalidStateException;
use Concrete\Api\Client\Provider\ProviderInterface;
use Concrete\Api\Client\Service\SiteDescription;
use Concrete\Api\Client\Service\SystemDescription;
use Concrete\OAuth2\Client\Provider\Concrete5;
use Concrete\OAuth2\Client\Provider\Concrete5ResourceOwner;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use kamermans\OAuth2\GrantType\AuthorizationCode;
use kamermans\OAuth2\GrantType\NullGrantType;
use kamermans\OAuth2\GrantType\RefreshToken;
use kamermans\OAuth2\OAuth2Middleware;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ClientFactory
{

    /**
     * @var LoggerInterface
     */
    protected $logger;


    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    private function createLoggingMiddleware(string $messageFormat)
    {
        return Middleware::log($this->logger, new MessageFormatter($messageFormat));
    }

    private function addLoggingHandler(HandlerStack $stack, array $messageFormats)
    {
        collect($messageFormats)->each(function ($messageFormat) use ($stack) {
            $stack->unshift(
                $this->createLoggingMiddleware($messageFormat)
            );
        });

        return $stack;
    }

    public function isClientAuthorized(ProviderInterface $provider)
    {
        if (!$provider->getTokenStore()->hasToken()) {
            return false;
        }
        return true;
    }

    /**
     * @param ProviderInterface $provider
     * @param array config - you can put additional scopes in here with ['scope' => 'system account etc']
     * @return RedirectResponse
     */
    public function redirectToAuthorizeUrl(ProviderInterface $provider, $config = [])
    {
        $config = array_merge($provider->getClientConfig(), $config);
        $oauthProvider = $provider->createAuthenticationProvider();
        $authorizeUrl = $oauthProvider->getAuthorizationUrl($config);
        $provider->getAuthenticationStateStore()->set($oauthProvider->getState());
        $provider->getTokenStore()->deleteToken();
        return new RedirectResponse($authorizeUrl);
    }

    /**
     * Authorizes the client with the access code and the state retrieved from the authorization server.
     * Returns the resource owner.
     * @param $accessCode
     * @param $state
     * @return Concrete5ResourceOwner
     */
    public function authorizeClient(ProviderInterface $provider, $authCode, $state)
    {
        if (!$state || $state != $provider->getAuthenticationStateStore()->get()) {
            throw new InvalidStateException(
                t('OAuth2 state parameter empty or did not match what was retrieved from the state store.')
            );
        }

        $client = $this->create($provider, [
            'code' => $authCode
        ]);

        $result = $client->account()->getResourceOwner();
        if ($result) {
            $json = $result->toArray();
            return new Concrete5ResourceOwner($json);
        }
    }

    public function create(ProviderInterface $provider, $config = [])
    {

        $oauthProvider = $provider->createAuthenticationProvider();

        $reauthClient = new \GuzzleHttp\Client([
            // URL for access_token request
            'base_uri' => $oauthProvider->getBaseAccessTokenUrl([])
        ]);

        $reauthConfig = array_merge([
            'code' => null,
            'client_id' => $provider->getClientId(),
            'client_secret' => $provider->getClientSecret(),
            'redirect_uri' => $provider->getRedirectUri(),
        ], $config);

        $authCodeGrant = new AuthorizationCode($reauthClient, $reauthConfig);
        $refreshGrant = new RefreshToken($reauthClient, $reauthConfig);
        $oauth = new OAuth2Middleware($authCodeGrant, $refreshGrant);
        $oauth->setTokenPersistence($provider->getTokenStore());

        $stack = HandlerStack::create();
        $stack = $this->addLoggingHandler($stack, [
            '{method} {uri} HTTP/{version} {req_body}',
            'RESPONSE: {code} - {res_body}',
        ]);
        $stack->push($oauth);

        $httpClient = new \GuzzleHttp\Client([
            'base_uri' => $provider->getBaseUrl(),
            'handler' => $stack,
            'auth'    => 'oauth',
        ]);

        $client = new Client($httpClient);
        foreach((array) $provider->getServiceDescriptions() as $description) {
            $client->addServiceDescription($description);
        }

        return $client;
    }


}