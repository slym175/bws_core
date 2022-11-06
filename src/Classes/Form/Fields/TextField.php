<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\HasPlaceholder;
use Bws\Core\Classes\Form\Concerns\HasValue;
use Bws\Core\Classes\Form\Concerns\IsAutoComplete;
use Bws\Core\Classes\Form\Concerns\IsFocus;
use Bws\Core\Exceptions\UnsupportedFieldTypeException;

class TextField extends Field
{
    use IsAutoComplete, IsFocus, HasPlaceholder, HasValue;

    protected $type = 'text';
    const TYPES = [
        "button",
        "color",
        "date",
        "datetime-local",
        "email",
        "file",
        "hidden",
        "image",
        "month",
        "number",
        "password",
        "range",
        "reset",
        "search",
        "submit",
        "tel",
        "text",
        "time",
        "url",
        "week"
    ];

    public function getType()
    {
        return $this->type;
    }

    protected function getFieldView()
    {
        return 'bws@core::utilities.form.fields.text_field';
    }

    public function make($name, $type = 'text')
    {
        try {
            if (!in_array($type, self::TYPES)) {
                throw new UnsupportedFieldTypeException();
            }
            $this->type = $type;
            return parent::make($name);
        } catch (UnsupportedFieldTypeException $e) {
            report($e->getMessage());
        }
    }
}
