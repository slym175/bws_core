<?php

namespace Bws\Core\Classes\Form\Concerns\Datetime;

trait HasMode
{
    protected $mode = 'single';

    public function getMode()
    {
        return $this->mode;
    }

    public function mode(string $mode = 'single')
    {
        if (!in_array($mode, self::MODES)) {
            $mode = 'single';
        }
        $this->mode = $mode;
        return $this;
    }
}
