<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\HasLabel;

class LabelField extends Field
{
    use HasLabel;

    protected function getFieldView()
    {
        return 'bws@core::utilities.form.fields.label_field';
    }
}
