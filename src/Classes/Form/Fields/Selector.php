<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\HasOptions;
use Bws\Core\Classes\Form\Concerns\HasValue;
use Bws\Core\Classes\Form\Concerns\IsMultiple;

class Selector extends Field
{
    use HasValue, HasOptions, IsMultiple;

    protected function getFieldView()
    {
        return 'bws@core::utilities.form.fields.selector';
    }
}
