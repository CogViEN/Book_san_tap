<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        return UserRoleEnum::getKeyByValue(0);
    }
}
