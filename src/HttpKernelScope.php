<?php
namespace Peridot\Plugin\HttpKernel;

use Peridot\Core\Scope;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class HttpKernelScope extends Scope
{
    /**
     * @var \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    protected $httpKernelApplication;

    /**
     * @param callable|HttpKernelInterface $factory
     */
    public function __construct($factory, $property = "client")
    {
        $httpKernelApplication = $factory;
        if (is_callable($factory)) {
            $httpKernelApplication = call_user_func($factory);
        }
        if (!$httpKernelApplication instanceof HttpKernelInterface) {
            throw new \RuntimeException("SilexScope construction requires an HttpKernelInterface");
        }
        $this->httpKernelApplication = $httpKernelApplication;
        $this->setHttpKernelClient(new Client($this->httpKernelApplication), $property);
    }

    /**
     * @param \Symfony\Component\HttpKernel\HttpKernelInterface $httpKernelApplication
     */
    public function setHttpKernelApplication(HttpKernelInterface $httpKernelApplication)
    {
        $this->httpKernelApplication = $httpKernelApplication;
        $this->setHttpKernelClient(new Client($httpKernelApplication));
        return $this;
    }

    /**
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function getHttpKernelApplication()
    {
        return $this->httpKernelApplication;
    }

    /**
     * Set a public property to the client in question
     *
     * @param Client $client
     * @param string $property
     */
    public function setHttpKernelClient(Client $client, $property = "client")
    {
        $this->$property = $client;
    }
} 
