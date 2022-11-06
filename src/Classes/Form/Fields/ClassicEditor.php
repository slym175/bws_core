<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\HasLabel;
use Bws\Core\Classes\Form\Concerns\HasPlaceholder;
use Bws\Core\Classes\Form\Concerns\HasValue;

class ClassicEditor extends Field
{
    use HasPlaceholder, HasValue, HasLabel;

    protected function getFieldView()
    {
        return 'bws@core::utilities.form.fields.classic_editor';
    }
}
