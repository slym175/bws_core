<?php

namespace Bws\Core\Facades;

use Bws\Core\Classes\Form\Fields\TextField;

class Form extends FormFacade
{
    public function textInput()
    {
        return new TextField();
    }
}
