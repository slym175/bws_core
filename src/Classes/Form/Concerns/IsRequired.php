<?php

namespace Bws\Core\Classes\Form\Concerns;

trait IsRequired
{
    protected $required = false;

    public function isRequired()
    {
        return $this->required;
    }

    public function required()
    {
        $this->required = true;
        return $this;
    }

}
