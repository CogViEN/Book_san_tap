<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Enums\UserRoleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Trait\TitleTrait;
use App\Http\Controllers\Trait\ResponseTrait;

class AuthController extends Controller
{
    use ResponseTrait;
    use TitleTrait;
    public function __construct()
    {

        $routerName = Route::currentRouteName();
        $title = ucfirst($this->getTitleRoute($routerName));

        View::share('title', $title);
    }

    public function login()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        try {
            // firstOrFail bắn ra exception
            $data = User::query()
                ->where('email', $request->get('email'))
                ->firstOrFail();

            if (!Hash::check($request->get('password'), $data->password)) {
                throw new Exception('Invalid password');
            }

            $user = User::query()
                ->where('email', $request->get('email'))
                ->first();


            auth()->login($user, true);

            $role = strtolower(UserRoleEnum::getKeyByValue(auth()->user()->role));

            return $this->successResponse($role);
        } catch (\Throwable $e) {
            dd($e);
            return $this->errorResponse('the email or password is incorrect');
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        $checkPhone = User::query()
            ->where('phone', $request->phone)
            ->first();
        if (!is_null($checkPhone)) {
            return $this->errorResponse('Phone is already');
        }

        $checkEmail = User::query()
            ->where('email', $request->email)
            ->first();
        if (!is_null($checkEmail)) {
            return $this->errorResponse('Email is already');
        }

        $data = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->get('password')),
            'role' => UserRoleEnum::OWNER,
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        return redirect()->route('login');
    }



    public function facebookpage()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookredirect()
    {
        $data = Socialite::driver('facebook')->user();
        dd($data);
    }

    public function googlepage()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleredirect()
    {
        $data = Socialite::driver('google')->user();
        dd($data);
    }
}
