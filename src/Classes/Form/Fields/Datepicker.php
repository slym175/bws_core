<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\Datetime\EnableTime;
use Bws\Core\Classes\Form\Concerns\Datetime\HasDateFormat;
use Bws\Core\Classes\Form\Concerns\Datetime\HasMode;
use Bws\Core\Classes\Form\Concerns\HasPlaceholder;
use Bws\Core\Classes\Form\Concerns\HasValue;

class Datepicker extends Field
{
    use HasPlaceholder, HasValue, HasDateFormat, EnableTime, HasMode;
    const MODES = ['single', 'multiple', 'range'];

    protected function getFieldView()
    {
        return 'bws@core::utilities.form.fields.datepicker';
    }
}
