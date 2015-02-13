<?php

namespace Somos;

final class Action
{
    private $matcher = '';

    private $callable = null;

    private $responder = null;

    public function __construct($matcher, callable $callable = null)
    {
        $this->matcher  = $matcher;
        $this->callable = $callable;
    }

    /**
     * @param $matcher
     * @param callable|null $callable
     * @return Action
     */
    public static function get($matcher, callable $callable = null)
    {
        return new static($matcher, $callable);
    }

    public function respondWith(callable $callable)
    {
        $this->responder = $callable;

        return $this;
    }

    public function getMatcher()
    {
        return $this->matcher;
    }

    public function handle()
    {
        $actionResult = null;
        if (is_callable($this->callable)) {
            $actionResult = call_user_func_array($this->callable, func_get_args());
        }

        if (is_callable($this->responder)) {
            $responderData = [];
            if ($actionResult) {
                $responderData = [$actionResult];
            }

            call_user_func_array($this->responder, $responderData);
        }
    }
}