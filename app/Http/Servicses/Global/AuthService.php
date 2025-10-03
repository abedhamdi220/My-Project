<?php

namespace App\Http\Servicses\Global;

use App\Enums\RoleUserEnum;
use App\Exceptions\GeneralException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register($attrs, $role = RoleUserEnum::Client)
    {
        $attrs['password'] = Hash::make($attrs['password']);
        $user = User::create(array_merge(
            $attrs,
            [
                "role" => $role
            ]
        ));
        $user->access_token = $user->createToken("API Token")->accessToken;
        return $user;
    }

    public function login($attrs, $role = RoleUserEnum::Client){
        if(Auth::attempt([
            "email" => $attrs["email"], 
            "password" => $attrs["password"], 
            "role" => $role
        ])){
                $user = User::find(Auth::id());
                $user->access_token = $user->createToken("API Token")->accessToken;
                return $user;
        }
        throw new GeneralException("Invalid credentials", 401);
    }

    public function profile(){
        return Auth::user();
    }
}
