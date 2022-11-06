<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\HasLabel;
use Bws\Core\Classes\Form\Concerns\HasValue;
use Bws\Core\Classes\Form\Concerns\IsChecked;

class Checkbox extends Field
{
    use HasLabel, HasValue, IsChecked;

    protected function getFieldView()
    {
        return 'bws@core::utilities.form.fields.checkbox';
    }
}
