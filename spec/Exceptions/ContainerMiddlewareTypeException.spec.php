<?php

use Ellipse\Middleware\Exceptions\ContainerMiddlewareTypeException;

describe('ContainerMiddlewareTypeException', function () {

    it('should extend TypeError', function () {

        $test = new ContainerMiddlewareTypeException('alias', 'middleware');

        expect($test)->toBeAnInstanceOf(TypeError::class);

    });

});
