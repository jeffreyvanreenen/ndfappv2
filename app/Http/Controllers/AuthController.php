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

        $user = User::updateOrCreate(
            [
                'azure_id' => $microsoft_user->id,
            ],
            [
                'name' => $microsoft_user->name,
                'email' => $microsoft_user->email,
                'azure_token' => $microsoft_user->token,
                'azure_nickname' => $microsoft_user->nickname,
                'azure_avatar' => $microsoft_user->avatar,
                'azure_userinfo' => json_encode($microsoft_user->user),
                'azure_job_title' => $microsoft_user->jobTitle,
                'azure_givenName' => $microsoft_user->givenName,
                'azure_surname' => $microsoft_user->surname,
            ]);

        Auth::login($user);

        return redirect('/dashboard');
    }


}
