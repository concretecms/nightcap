<?php
namespace Concrete\Nightcap\OAuth2\Middleware\Client;


use Concrete\Nightcap\OAuth2\Configuration\ConfigurationInterface;
use GuzzleHttp\Client;
use League\OAuth2\Client\Provider\AbstractProvider;

class AuthorizationClientFactory
{

    /**
     * @var AbstractProvider
     */
    protected $oauthProvider;

    public function __construct(AbstractProvider $oauthProvider)
    {
        $this->oauthProvider = $oauthProvider;
    }

    public function createClient()
    {
        $baseUri = $this->oauthProvider->getBaseAccessTokenUrl([]);
        $reauthClient = new Client(['base_uri' => $baseUri]);
        return $reauthClient;
    }
}