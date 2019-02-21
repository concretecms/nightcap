<?php
namespace Concrete\Api\Client\Service\Description;

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