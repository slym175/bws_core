<?php

namespace Bws\Core\Traits;

use Bws\Core\Classes\Form\Fields\ActionField;
use Bws\Core\Classes\Form\Fields\Checkbox;
use Bws\Core\Classes\Form\Fields\Checkboxes;
use Bws\Core\Classes\Form\Fields\ClassicEditor;
use Bws\Core\Classes\Form\Fields\Datepicker;
use Bws\Core\Classes\Form\Fields\FieldsGroup;
use Bws\Core\Classes\Form\Fields\HtmlField;
use Bws\Core\Classes\Form\Fields\LabelField;
use Bws\Core\Classes\Form\Fields\Radio;
use Bws\Core\Classes\Form\Fields\Radios;
use Bws\Core\Classes\Form\Fields\Selector;
use Bws\Core\Classes\Form\Fields\Textarea;
use Bws\Core\Classes\Form\Fields\TextField;

trait LoadFieldsSingleton
{
    protected function registerFieldsSingleton()
    {
        $this->app->bind('TextField', function () {
            return new TextField();
        });
        $this->app->bind('LabelField', function () {
            return new LabelField();
        });
        $this->app->bind('FieldsGroup', function () {
            return new FieldsGroup();
        });
        $this->app->bind('ActionField', function () {
            return new ActionField();
        });
        $this->app->bind('Textarea', function () {
            return new Textarea();
        });
        $this->app->bind('ClassicEditor', function () {
            return new ClassicEditor();
        });
        $this->app->bind('Checkbox', function () {
            return new Checkbox();
        });
        $this->app->bind('Checkboxes', function () {
            return new Checkboxes();
        });
        $this->app->bind('Radio', function () {
            return new Radio();
        });
        $this->app->bind('Radios', function () {
            return new Radios();
        });
        $this->app->bind('Selector', function () {
            return new Selector();
        });
        $this->app->bind('Datepicker', function () {
            return new Datepicker();
        });
        $this->app->bind('HtmlField', function () {
            return new HtmlField();
        });
    }
}
