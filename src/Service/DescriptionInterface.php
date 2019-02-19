<?php
namespace Concrete\Api\Client\Service;

interface DescriptionInterface
{

    /**
     * @return string
     */
    public function getNamespace();

    /**
     * Returns the DSL for the web service.
     * @return array
     */
    public function getDescription();

}