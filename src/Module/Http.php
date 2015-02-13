<?php

namespace Somos\Module;

class Http
{
    public function __invoke()
    {
        return [
            \Phly\Http\ServerRequest::class => \DI\factory(function () {
                return \Phly\Http\ServerRequestFactory::fromGlobals();
            }),
        ];
    }
}