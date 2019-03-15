<?php
namespace Concrete\Nightcap;

use Concat\Http\Middleware\Logger;
use Concrete\Nightcap\OAuth2\Middleware\MiddlewareFactory;
use Concrete\Nightcap\Service\ServiceCollection;
use Concrete\Nightcap\Service\ServiceDescriptionFactory;
use GuzzleHttp\HandlerStack;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class ClientFactory implements ClientFactoryInterface
{

    /**
     * @var MiddlewareFactory
     */
    protected $middlewareFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ServiceClientFactory
     */
    protected $serviceClientFactory;

    /**
     * @var ServiceDescriptionFactory
     */
    protected $serviceDescriptionFactory;

    /**
     * @var ServiceCollection
     */
    protected $serviceCollection;

    public function __construct(
        MiddlewareFactory $middlewareFactory,
        ServiceClientFactory $serviceClientFactory,
        ServiceDescriptionFactory $serviceDescriptionFactory,
        ServiceCollection $serviceCollection,
        LoggerInterface $logger = null)
    {
        $this->middlewareFactory = $middlewareFactory;
        $this->serviceClientFactory = $serviceClientFactory;
        $this->serviceDescriptionFactory = $serviceDescriptionFactory;
        $this->serviceCollection = $serviceCollection;
        if ($logger) {
            $this->logger = $logger;
        }
    }

    /**
     * @return MiddlewareFactory
     */
    public function getMiddlewareFactory(): MiddlewareFactory
    {
        return $this->middlewareFactory;
    }

    public function create($config = [])
    {
        $oauth = $this->middlewareFactory->create();
        $stack = HandlerStack::create();
        if ($this->logger) {
            $middleware = new Logger($this->logger);
            $middleware->setRequestLoggingEnabled(true);
            $middleware->setLogLevel(LogLevel::INFO);
            $stack->unshift($middleware);
        }

        $stack->push($oauth);

        $httpClient = new \GuzzleHttp\Client([
            'base_uri' => $this->middlewareFactory->getConfiguration()->getBaseUrl(),
            'handler' => $stack,
            'auth'    => 'oauth',
        ]);

        $client = new Client(
            $httpClient,
            $this->serviceCollection,
            $this->serviceClientFactory,
            $this->serviceDescriptionFactory
        );

        return $client;
    }


}