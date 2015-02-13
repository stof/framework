<?php

namespace Somos\Http;

use Somos\Actions;
use Somos\Http\Routing\Route;
use Phly\Http\ServerRequest;
use Somos\Http\Routing\Collection;
use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;

final class HandleRequestHandler implements MessageHandler
{
    /** @var ServerRequest */
    private $request;

    /** @var Actions */
    private $actions;

    public function __construct(Actions $actions, ServerRequest $request)
    {
        $this->request = $request;
        $this->actions = $actions;
    }

    public function handle(Message $message)
    {
        $actions = $this->actions;
        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) use ($actions) {
            foreach($actions as $action) {
                if ($action->getMatcher() instanceof Route == false) {
                    continue;
                }

                $route = $action->getMatcher();
                $r->addRoute(
                    $route->method,
                    $route->uriTemplate,
                    function ($variables = []) use ($action) {
                        // TODO: Extract (post) variables from request and insert into action some way easy to consume
                        // URI Variables = parameter
                        // Get Variables = parameter
                        // POST Variables = entity object added to parameters
                        $action->handle($variables);
                    }
                );
            }
        });

        $routeInfo = $dispatcher->dispatch($this->request->getMethod(), (string)$this->request->getUri()->getPath());

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                var_dump('test1');
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                var_dump('test2');
                break;
            case \FastRoute\Dispatcher::FOUND:
                list(,$handler, $vars) = $routeInfo;
                $handler($vars);
                break;
        }
    }
}