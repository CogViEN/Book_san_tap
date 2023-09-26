<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PitchArea extends Component
{
    public object $pitchArea;
    public string $image;
    public string $owner;

    public function __construct($pitchArea, $image, $owner)
    {
        $this->pitchArea = $pitchArea;
        $this->image = $image;
        $this->owner = $owner;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pitch-area');
    }
}
