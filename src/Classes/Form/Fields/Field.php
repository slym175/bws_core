<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\HasClassName;
use Bws\Core\Classes\Form\Concerns\HasAttributes;
use Bws\Core\Classes\Form\Concerns\HasID;
use Bws\Core\Classes\Form\Concerns\HasValue;
use Bws\Core\Classes\Form\Concerns\IsRequired;
use Bws\Core\Exceptions\NoFieldNameException;
use Illuminate\Contracts\Support\Renderable;

abstract class Field implements Renderable
{
    use HasClassName, HasID, HasAttributes, IsRequired;

    protected $name = null;
    protected $hasName = true;

    public function getName()
    {
        return $this->name;
    }

    public function hasName()
    {
        return $this->hasName;
    }

    public function render()
    {
        try {
            if ((!isset($this->name) || !$this->name) && $this->hasName()) {
                throw new NoFieldNameException();
            }
            $formAttr = get_object_vars($this);

            return view($this->getFieldView() ?? 'bws@core::utilities.form.fields.default_field', $formAttr);
        } catch (NoFieldNameException $e) {
            report($e->getMessage());
        }
    }

    public function make($name)
    {
        $this->name = $name;
        return $this;
    }

    abstract protected function getFieldView();
}
