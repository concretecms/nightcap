<?php
namespace Concrete\Api\Client;

interface ClientFactoryInterface
{

    /**
     * @return Client
     */
    public function create($config = []);

}