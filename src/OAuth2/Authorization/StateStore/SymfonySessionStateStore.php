<?php
namespace Concrete\Api\Client\OAuth2\Authorization\StateStore;

use Symfony\Component\HttpFoundation\Session\Session;

class SymfonySessionStateStore implements StateStoreInterface
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