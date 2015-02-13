<?php

namespace Somos\Module;

use Somos\Module as SomosModule;

final class Http implements SomosModule
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