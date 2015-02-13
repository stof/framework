<?php

namespace Somos\MessageBus;

use Assert\Assertion;
use DI\Container;
use SimpleBus\Message\Handler\Map\Exception\NoHandlerForMessageName;
use SimpleBus\Message\Handler\Map\MessageHandlerMap;

final class LazyLoadingPhpDiMessageHandlerMap implements MessageHandlerMap
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function handlerByMessageName($messageName)
    {
        if (class_exists($messageName) == false) {
            throw new \InvalidArgumentException(
                'The provided message name should be an existing class, received "'. $messageName . '"'
            );
        }

        $handlerClassName = $messageName . 'Handler';
        if (class_exists($handlerClassName) == false) {
            throw new NoHandlerForMessageName($messageName);
        }

        return $this->loadHandlerService($handlerClassName);
    }

    private function loadHandlerService($handlerClassName)
    {
        $messageHandler = $this->container->get($handlerClassName);

        Assertion::isInstanceOf($messageHandler, 'SimpleBus\Message\Handler\MessageHandler');

        return $messageHandler;
    }
}
