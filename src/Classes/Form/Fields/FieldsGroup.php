<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\HasFields;

class FieldsGroup extends Field
{
    use HasFields;

    public function hasName()
    {
        return false;
    }

    protected function getFieldView()
    {
        return 'bws@core::utilities.form.fields.fields_group';
    }
}
