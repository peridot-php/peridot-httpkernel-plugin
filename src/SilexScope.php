<?php
namespace Peridot\Plugin\Silex;

use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class SilexScope
{
    /**
     * @var \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    protected $silexApplication;

    /**
     * @param callable $factory
     */
    public function __construct(callable $factory, $property = "client")
    {
        $silexApplication = call_user_func($factory);
        if (!$silexApplication instanceof HttpKernelInterface) {
            throw new \RuntimeException("SilexScope factory must return an HttpKernelInterface");
        }
        $this->silexApplication = $silexApplication;
        $this->setHttpKernelClient(new Client($this->silexApplication), $property);
    }

    /**
     * @param \Symfony\Component\HttpKernel\HttpKernelInterface $silexApplication
     */
    public function setSilexApplication(HttpKernelInterface $silexApplication)
    {
        $this->silexApplication = $silexApplication;
        $this->setHttpKernelClient(new Client($silexApplication));
        return $this;
    }

    /**
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function getSilexApplication()
    {
        return $this->silexApplication;
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
