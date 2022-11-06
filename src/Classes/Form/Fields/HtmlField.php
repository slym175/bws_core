<?php

namespace Bws\Core\Classes\Form\Fields;

use Bws\Core\Classes\Form\Concerns\HasFields;
use Illuminate\Support\Str;

class HtmlField extends Field
{
    use HasFields;

    protected $htmlFieldContent = '';

    public function hasName()
    {
        return false;
    }

    protected function getFieldView()
    {
        return 'bws@core::utilities.form.fields.html_field';
    }

    public function content(string|callable|Closure $content = '') {
        if(is_callable($content)) $content = $content();
        $this->htmlFieldContent = Str::replace('[fields]', 'Hellosoooo', $content);

        return $this;
    }
}
