<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasMethod
{
    private $method = 'GET';

    public function getMethod(): string
    {
        return $this->method;
    }

    public function method(string|Closure|callable $method = 'GET')
    {
        if(is_callable($method)) $method = $method();

        $this->method = $method;
        return $this;
    }
}
