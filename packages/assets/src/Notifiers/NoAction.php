<?php

namespace Bws\Assets\Notifiers;

use Bws\Assets\SetStateTrait;

class NoAction implements NotifierInterface
{
    use SetStateTrait;

    /**
     * This notifier doesn't actually do anything.
     * It's used by the unit tests.
     *
     * You can use it as a template to create your own notifier.
     *
     * @param string $asset The filename of the asset.
     */
    public function created($asset)
    {
        // $asset was just created.  Copy it somewhere.
    }
}
