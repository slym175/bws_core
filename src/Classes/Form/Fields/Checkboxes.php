<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\HasOptions;
use Bws\Core\Classes\Form\Concerns\HasValue;

class Checkboxes extends Field
{
    use HasValue, HasOptions;

    protected function getFieldView()
    {
        return 'bws@core::utilities.form.fields.checkboxes';
    }
}
