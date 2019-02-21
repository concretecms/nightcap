<?php
namespace Concrete\Api\Client\OAuth2;

/**
 * Stores and retrieve OAuth2 state from our provider.
 * Interface AuthorizationStateStoreInterface
 * @package Concrete\Api\Client\Service
 */
interface AuthorizationStateStoreInterface
{

    /**
     * @return string
     */
    public function get();

    /**
     * @param $state
     * @return mixed
     */
    public function set($state);
}