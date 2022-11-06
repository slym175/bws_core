<?php

namespace Bws\Core\Classes\Form\Concerns\Datetime;

trait HasDateFormat
{
    protected $dateFormat = 'Y-m-d';

    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    public function dateFormat($dateFormat = 'Y-m-d')
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }
}
