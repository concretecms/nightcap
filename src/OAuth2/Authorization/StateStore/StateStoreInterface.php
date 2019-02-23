<?php
namespace Concrete\Api\Client\OAuth2\Authorization\StateStore;

/**
 * Stores and retrieve OAuth2 state from our provider.
 */
interface StateStoreInterface
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