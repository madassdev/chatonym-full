<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FeedCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $has_comments;

    public function __construct($has_comments = false)
    {
        $this->has_comments = $has_comments;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.feed-card');
    }
}
