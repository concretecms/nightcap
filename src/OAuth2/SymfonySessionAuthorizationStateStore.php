<?php
namespace Concrete\Api\Client\OAuth2;

use Symfony\Component\HttpFoundation\Session\Session;

class SymfonySessionAuthorizationStateStore implements AuthorizationStateStoreInterface
{

    /**
     * @var Session
     */
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function set($state)
    {
        $this->session->set('oauth2state', $state);
    }

    public function get()
    {
        return $this->session->get('oauth2state');
    }
    
}