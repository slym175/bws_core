<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasFields
{
    protected $fields = [];

    public function getFields()
    {
        return $this->renderField();
    }

    public function fields(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    protected function renderField()
    {
        return $this->fields;
    }
}
