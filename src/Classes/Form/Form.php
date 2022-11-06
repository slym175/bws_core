<?php

namespace Bws\Core\Classes\Form;

use Bws\Core\Classes\Form\Concerns\HasActions;
use Bws\Core\Classes\Form\Concerns\HasAttributes;
use Bws\Core\Classes\Form\Concerns\HasFormAction;
use Bws\Core\Classes\Form\Concerns\HasClassName;
use Bws\Core\Classes\Form\Concerns\HasEnctype;
use Bws\Core\Classes\Form\Concerns\HasFields;
use Bws\Core\Classes\Form\Concerns\HasID;
use Bws\Core\Classes\Form\Concerns\HasMethod;
use Illuminate\Contracts\Support\Renderable;

class Form implements Renderable
{
    use HasActions, HasFormAction, HasClassName, HasEnctype, HasFields, HasID, HasMethod, HasAttributes;

    protected $before_form_fields_hook = '';
    protected $after_form_fields_hook = '';

    public function render()
    {
        $formAttr = get_object_vars($this);
        return view('bws@core::utilities.form.form', $formAttr);
    }

    public function getHooks()
    {
        return [$this->before_form_fields_hook, $this->after_form_fields_hook];
    }

    public function hooks($hooks = [])
    {
        $id = $this->getId() ? $this->getId() . '_' : '';

        if (!isset($hooks[0]) || !$hooks[0]) {
            $this->before_form_fields_hook = 'before_form_' . $id . 'fields';
            $this->after_form_fields_hook = 'after_form_' . $id . 'fields';
        }
        if (!isset($hooks[1]) || !$hooks[1]) {
            $this->after_form_fields_hook = 'after_form_' . $id . 'fields';
        } else {
            $this->before_form_fields_hook = $hooks[0];
            $this->after_form_fields_hook = $hooks[1];
        }

        return $this;
    }
}
