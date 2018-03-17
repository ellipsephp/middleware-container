<?php

use Ellipse\Middleware\Exceptions\ContainedMiddlewareTypeException;
use Ellipse\Middleware\Exceptions\ContainerMiddlewareExceptionInterface;

describe('ContainedMiddlewareTypeException', function () {

    beforeEach(function () {

        $this->exception = new ContainedMiddlewareTypeException('id', 'middleware');

    });

    it('should implement ContainerMiddlewareExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(ContainerMiddlewareExceptionInterface::class);

    });

    it('should extend TypeError', function () {

        expect($this->exception)->toBeAnInstanceOf(TypeError::class);

    });

});
