<?php

namespace Somos\Http\Routing;

final class Collection extends \ArrayObject
{
    public function __construct()
    {
        parent::__construct([]);
    }

    /**
     * @param array $routes
     *
     * @return $this
     */
    public static function create(array $routes = [])
    {
        $collection = new static();

        foreach($routes as $route) {
            $collection[] = $route;
        }

        return $collection;
    }

    /**
     * @param $uriTemplate
     * @return Route
     */
    public function add($uriTemplate)
    {
        $route  = Route::create($uriTemplate);
        $this[] = $route;

        return $route;
    }

    /**
     * @param integer $index
     *
     * @return Route
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }

    /**
     * @param integer $index
     * @param Route   $newval
     */
    public function offsetSet($index, $newval)
    {
        parent::offsetSet($index, $newval);
    }

    /**
     * @return Route[]
     */
    public function getArrayCopy()
    {
        return parent::getArrayCopy();
    }
}