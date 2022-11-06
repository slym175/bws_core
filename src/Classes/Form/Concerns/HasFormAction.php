<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasFormAction
{
    protected $action = '';

    public function getAction(): string
    {
        return $this->action;
    }

    public function formAction(string|Closure|callable $action = '/')
    {
        if(is_callable($action)) $action = $action();

        $this->action = $action;
        return $this;
    }

    public function routeAction(string $name, array $parameters = [], bool $absolute = true) {
        $this->action = router_url($name, $parameters, $absolute);
        return $this;
    }
}
