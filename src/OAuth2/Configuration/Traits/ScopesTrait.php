<?php
namespace Concrete\Api\Client\OAuth2\Configuration\Traits;

trait ScopesTrait
{

    /**
     * @var array
     */
    protected $scopes = [];

    /**
     * @return array
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }

    /**
     * @param array $scopes
     */
    public function setScopes(array $scopes): void
    {
        $this->scopes = $scopes;
    }




}