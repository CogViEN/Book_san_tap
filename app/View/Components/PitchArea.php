<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PitchArea extends Component
{
    public object $pitchArea;
    public string $image;
    public string $owner;
    public string $routeEditInfo;
    public string $routeViewDetail;


    public function __construct($pitchArea, $image, $owner)
    {
        $this->pitchArea = $pitchArea;
        $this->image = $image;
        $this->owner = $owner;
        if(isAdmin() || isSuperAdmin()){
            $this->routeViewDetail = route('admin.pitchareas.show.pitch', $pitchArea);
            $this->routeEditInfo = route('admin.pitchareas.edit.info', $pitchArea);
        }
        else if(isOwner()){
            $this->routeViewDetail = route('owner.pitchareas.show.pitch', $pitchArea);
            $this->routeEditInfo = route('owner.pitchareas.edit.info', $pitchArea);
        }
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
