<?php

namespace Somos\Http\Routing;

final class Route
{
    const METHOD_GET    = 'GET';
    const METHOD_HEAD   = 'HEAD';
    const METHOD_POST   = 'POST';
    const METHOD_PUT    = 'PUT';
    const METHOD_DELETE = 'DELETE';

    /** @var string */
    public $method = self::METHOD_GET;

    /** @var string */
    public $uriTemplate = '/';

    private function __construct($uriTemplate)
    {
        $this->uriTemplate = $uriTemplate;
    }

    public static function create($uriTemplate)
    {
        return new static($uriTemplate);
    }

    public function get()
    {
        $this->method = self::METHOD_GET;

        return $this;
    }

    public function post()
    {
        $this->method = self::METHOD_POST;

        return $this;
    }

    public function head()
    {
        $this->method = self::METHOD_HEAD;

        return $this;
    }

    public function put()
    {
        $this->method = self::METHOD_PUT;

        return $this;
    }

    public function delete()
    {
        $this->method = self::METHOD_DELETE;

        return $this;
    }
}