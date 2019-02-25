<?php
namespace Concrete\Nightcap\OAuth2\Exception;

/**
 * Thrown if we're attempting to use the authorization flow with a grant type other than the Authorization Code
 * grant type
 *
 */
class InvalidGrantTypeException extends \RuntimeException
{


}