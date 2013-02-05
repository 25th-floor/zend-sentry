<?php

namespace ZendSentry;

use Raven_Client as RavenClient;
use Raven_ErrorHandler as RavenErrorHandler;

class ZendSentry
{
    /**
     * @var RavenClient $ravenClient
     */
    private $ravenClient;

    /**
     * @var RavenErrorHandler $ravenErrorHandler
     */
    private $ravenErrorHandler;

    /**
     * @param RavenClient $ravenClient
     * @param RavenErrorHandler $ravenErrorHandler
     */
    public function __construct(RavenClient $ravenClient, RavenErrorHandler $ravenErrorHandler = null)
    {
        $this->ravenClient = $ravenClient;
        $this->setOrLoadRavenErrorHandler($ravenErrorHandler);
    }

    /**
     * @param bool $callExistingHandler
     * @param null $errorReporting
     * @return ZendSentry
     */
    public function registerErrorHandler($callExistingHandler = true, $errorReporting = null)
    {
        $this->ravenErrorHandler->registerErrorHandler($callExistingHandler, $errorReporting);
        return $this;
    }

    /**
     * @param bool $callExistingHandler
     * @return ZendSentry
     */
    public function registerExceptionHandler($callExistingHandler = true)
    {
        $this->ravenErrorHandler->registerExceptionHandler($callExistingHandler);
        return $this;
    }

    /**
     * @param int $reservedMemorySize
     * @return ZendSentry
     */
    public function registerShutdownFunction($reservedMemorySize = 10)
    {
        $this->ravenErrorHandler->registerShutdownFunction($reservedMemorySize);
        return $this;
    }

    /**
     * @param $ravenErrorHandler
     */
    private function setOrLoadRavenErrorHandler($ravenErrorHandler)
    {
        if ($ravenErrorHandler !== null) {
            $this->ravenErrorHandler = $ravenErrorHandler;
        }
        else {
            $this->ravenErrorHandler = new RavenErrorHandler($this->ravenClient);
        }
    }
}