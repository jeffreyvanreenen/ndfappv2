<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function login()
    {
        return Socialite::driver('microsoft')->redirect();
    }
    public function loginWithAzure()
    {
        $microsoft_user = Socialite::driver('microsoft')->user();

        dd($microsoft_user);

        $user = User::updateOrCreate(
            [
                'azure_id' => $microsoft_user->id,
            ],
            [
                'name' => $microsoft_user->name,
                'email' => $microsoft_user->email,
                'azure_token' => $microsoft_user->token,
            ]);

        Auth::login($user);

        return redirect('/dashboard');
    }


}
