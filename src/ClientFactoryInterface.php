<?php
namespace Concrete\Nightcap;

interface ClientFactoryInterface
{

    /**
     * @return Client
     */
    public function create($config = []);

}