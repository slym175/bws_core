<?php

namespace Bws\Core\Classes\Form\Concerns\Datetime;

trait EnableTime
{
    protected $enableTime = false;

    public function isEnableTime()
    {
        return $this->enableTime;
    }

    public function enableTime()
    {
        $this->enableTime = true;
        return $this;
    }
}
