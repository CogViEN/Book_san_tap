<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Support\Str;
use App\Enums\StatusPostEnum;
use Illuminate\View\Component;

class post extends Component
{
    public $id;
    public $user_id;
    public string $heading;
    public array $user;
    public string $description;
    public string $avatar;
    public string $status;
    public string $created_at;

    public function __construct($obj)
    {
        $this->id = $obj->id;
        $this->user_id = $obj->user_id;
        $this->user = User::query()
            ->where('id', $this->user_id)
            ->first()
            ->toArray();
        $this->heading = $obj->heading;
        $this->description = Str::limit(strip_tags($obj->description), 50);
        $this->avatar = $obj->avatar;
        $this->status = StatusPostEnum::getKeyByValue($obj->status);
        $this->created_at = $obj->created_at;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.post');
    }
}
