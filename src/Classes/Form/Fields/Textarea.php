<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\HasPlaceholder;
use Bws\Core\Classes\Form\Concerns\HasRows;
use Bws\Core\Classes\Form\Concerns\HasValue;

class Textarea extends Field
{
    use HasPlaceholder, HasValue, HasRows;

    protected function getFieldView()
    {
        return 'bws@core::utilities.form.fields.textarea';
    }
}
