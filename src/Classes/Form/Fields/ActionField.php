<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\HasAttributes;
use Bws\Core\Classes\Form\Concerns\HasFormAction;
use Bws\Core\Classes\Form\Concerns\HasIcon;
use Bws\Core\Classes\Form\Concerns\HasLabel;
use Bws\Core\Classes\Form\Concerns\HasValue;
use Bws\Core\Exceptions\UnsupportedFieldTypeException;

class ActionField extends Field
{
    use HasLabel, HasValue, HasIcon, HasFormAction, HasAttributes;

    protected $type = 'button';
    const TYPES = ['button', 'ajax', 'submit'];

    public function getType()
    {
        return $this->type;
    }

    public function make($name, $type = 'button')
    {
        if (!in_array($type, self::TYPES)) {
            throw new UnsupportedFieldTypeException();
        }
        $this->type = $type;
        return parent::make($name);
    }

    protected function getFieldView()
    {
        return 'bws@core::utilities.form.fields.action_field';
    }
}
