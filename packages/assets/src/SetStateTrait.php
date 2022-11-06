<?php

namespace Bws\Assets;

trait SetStateTrait
{
    /**
     * Allow the object to be serialized in laravel's config cache
     *
     * @return static
     */
    public static function __set_state(array $properties)
    {
        return new static();
    }
}
