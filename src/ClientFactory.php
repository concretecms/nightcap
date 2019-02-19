<?php
namespace Concrete\Api\Client;

use Concrete\Api\Client\Provider\ProviderInterface;
use Concrete\Api\Client\Service\SiteDescription;
use Concrete\Api\Client\Service\SystemDescription;
use Concrete\OAuth2\Client\Provider\Concrete5;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use kamermans\OAuth2\GrantType\AuthorizationCode;
use kamermans\OAuth2\GrantType\NullGrantType;
use kamermans\OAuth2\GrantType\RefreshToken;
use kamermans\OAuth2\OAuth2Middleware;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

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


    public function create(ProviderInterface $provider)
    {
        $oauthProvider = $provider->createOauthProvider();

        $cache = \Core::make('cache/expensive');
        $item = $cache->getItem('oauth2-access-token');
        $accessToken = $item->get();
        if ($item->isMiss()) {
            // uh oh
        }

        if ($accessToken->hasExpired()) {
            $accessToken = $provider->getAccessToken('refresh_token', [
                'refresh_token' => $accessToken->getRefreshToken()
            ]);
            $item = $cache->getItem('oauth2-access-token');
            $cache->save($item->set($token));
        }

        $oauth = new OAuth2Middleware(new NullGrantType());
        $oauth->setAccessToken($accessToken->getToken());
        $stack = HandlerStack::create();
        $stack = $this->addLoggingHandler($stack, [
            '{method} {uri} HTTP/{version} {req_body}',
            'RESPONSE: {code} - {res_body}',
        ]);
        $stack->push($oauth);
        $httpClient = new \GuzzleHttp\Client([
            'base_uri' => $provider->getBaseUrl(),
            'auth' => 'oauth',
            'handler' => $stack,
        ]);

        $client = new Client($httpClient);
        $client->addServiceDescription(new SiteDescription());
        $client->addServiceDescription(new SystemDescription());
        return $client;
    }


}