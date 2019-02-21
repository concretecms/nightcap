<?php
namespace Concrete\Api\Client\OAuth2\Exception;

/**
 * Thrown if the state received from the authorization server doesn't match what's stored in the state store,
 * or if the state parameter is empty.
 *
 * Class InvalidStateException
 * @package Concrete\Api\Client\OAuth2\Exception
 */
class InvalidStateException extends \RuntimeException
{


}