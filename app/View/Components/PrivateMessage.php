<?php

namespace App\View\Components;

use App\Models\Message;
use Illuminate\View\Component;

class PrivateMessage extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $message;
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.private-message');
    }
}
