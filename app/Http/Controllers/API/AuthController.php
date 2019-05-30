<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        // TODO
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => request('email'),
            'password' => request('password'),
        ];

        if(Auth::attempt($credentials)){
            $user = Auth::user();


        }

        return $this->error('');
    }
}
