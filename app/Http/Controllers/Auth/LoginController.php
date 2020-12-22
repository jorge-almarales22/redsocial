<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();
        $user = User::where('provider_id', $facebookUser->getId())->first();
        if(!$user)
        {
            $user = User::create([
                'name' => $facebookUser->getName(),
                'lastname' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'provider_id' => $facebookUser->getId(),
                'email_verified_at' => date('Y-m-d'),
            ]);
        }
        Auth::login($user, true);
        return redirect($this->redirectTo);

        // $user->token;
    }    
}
