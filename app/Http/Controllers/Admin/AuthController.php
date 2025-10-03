<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleUserEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Global\LoginRequest;
use App\Http\Servicses\Global\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function loginView(){
        return view("auth.login");
    }

    public function login(LoginRequest $request){
        $attr = $request->validated();
        $user = $this->authService->login($attr, RoleUserEnum::Admin);
        Auth::login($user);
        return redirect()->route('home');
    }

    public function logout(){
        Auth::logout();
        // redirect to login page (not to home which is protected)
        return redirect()->route('login');
    }
}
