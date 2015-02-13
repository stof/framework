<?php

namespace Somos;

final class Actions extends \ArrayObject
{
    public function add($matcher, callable $action = null)
    {
        $action = new Action($matcher, $action);

        $this[] = $action;

        return $action;
    }
}