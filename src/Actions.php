<?php

namespace Somos;

final class Actions extends \ArrayObject
{
    public function offsetSet($index, $newval)
    {
        if ($newval instanceof Action == false) {
            throw new \InvalidArgumentException(
                'Only actions may be added to the Actions collection, received: ' . get_class($newval)
            );
        }

        parent::offsetSet($index, $newval);
    }
}