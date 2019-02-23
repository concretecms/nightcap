<?php
namespace Concrete\Api\Client\OAuth2\Authorization\StateStore;

class NativeSessionStateStore implements StateStoreInterface
{

    public function set($state)
    {
        $_SESSION['oauth2state'] = $state;
    }

    public function get()
    {
        return $_SESSION['oauth2state'];
    }

}