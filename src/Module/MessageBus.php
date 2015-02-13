<?php

namespace Somos\Module;

use Somos\Module as SomosModule;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Map\MessageHandlerMap;
use SimpleBus\Message\Handler\Resolver\MessageHandlerResolver;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;
use SimpleBus\Message\Name\MessageNameResolver;
use Somos\MessageBus\LazyLoadingPhpDiMessageHandlerMap;

final class MessageBus implements SomosModule
{
    public function __invoke()
    {
        return [
            MessageHandlerResolver::class => \DI\object(NameBasedMessageHandlerResolver::class),
            MessageNameResolver::class => \DI\object(ClassBasedNameResolver::class),
            MessageHandlerMap::class => \DI\object(LazyLoadingPhpDiMessageHandlerMap::class),
            MessageBusSupportingMiddleware::class => \DI\object()
                ->method('appendMiddleware', \DI\link(FinishesHandlingMessageBeforeHandlingNext::class))
                ->method('appendMiddleware', \DI\link(DelegatesToMessageHandlerMiddleware::class)),
        ];
    }
}