<?php

namespace App\View\Components;

use App\Enums\PitchTypeEnum;
use Illuminate\View\Component;

class PitchAreaEndUser extends Component
{
   public $id;
   public string $name;
   public string $address;
   public string $type;
   public string $reference_price;
   public string $avatar;

    public function __construct($obj)
    {
        $this->id = $obj->id;
        $this->name = $obj->name;
        $this->address = $obj->address;
        $this->reference_price = $obj->cost;
        $this->avatar = $obj->avatar;

        $this->type = 'Includes: ';
        foreach($obj->pitch as $_pitch){
            $this->type .= PitchTypeEnum::getKeyByValue($_pitch->type) . ' ,';
        }
        $this->type = substr_replace($this->type ,"",-1);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pitch-area-end-user');
    }
}
