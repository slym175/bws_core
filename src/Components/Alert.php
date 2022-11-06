<?php

namespace Bws\Core\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    protected $message;
    protected $type;
    protected $dismissible;

    public function __construct($message = '', $type = 'primary', $dismissible = true)
    {
        $this->message = $message;
        $this->type = $type;
        $this->dismissible = $dismissible;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('bws@core::components.alert', [
            'message' => $this->message,
            'type' => $this->type,
            'dismissible' => $this->dismissible,
        ]);
    }
}
