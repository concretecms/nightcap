<?php
namespace Concrete\Nightcap;

use Concrete\Nightcap\OAuth2\Middleware\MiddlewareFactory;
use Concrete\Nightcap\Provider\ProviderInterface;
use Concrete\Nightcap\Service\ServiceCollection;
use Concrete\Nightcap\Service\ServiceDescriptionFactory;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;

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


    private function createLoggingMiddleware(string $messageFormat)
    {
        return Middleware::log($this->logger, new MessageFormatter($messageFormat));
    }

    private function addLoggingHandler(HandlerStack $stack, array $messageFormats)
    {
        foreach($messageFormats as $messageFormat) {
            $stack->unshift(
                $this->createLoggingMiddleware($messageFormat)
            );
        }
        return $stack;
    }

    public function create($config = [])
    {
        $oauth = $this->middlewareFactory->create();
        $stack = HandlerStack::create();
        if ($this->logger) {
            $stack = $this->addLoggingHandler($stack, [
                '{method} {uri} HTTP/{version} {req_body}',
                'RESPONSE: {code} - {res_body}',
            ]);
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