<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Enums\UserRoleEnum;
use Illuminate\Http\Request;
use App\Enums\StatusPitchEnum;

class TestController extends Controller
{
    public function test()
    {
        return StatusPitchEnum::getKeyByValue(0);
    }
}
