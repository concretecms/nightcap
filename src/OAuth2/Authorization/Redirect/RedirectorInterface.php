<?php
namespace Concrete\Api\Client\OAuth2\Authorization\Redirect;

/**
 * Redirects to the authorization URL
 */
interface RedirectorInterface
{

    public function redirect($authorizationUrl);

}