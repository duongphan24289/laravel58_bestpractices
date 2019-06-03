<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use Illuminate\Auth\AuthenticationException;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct()
    {}

    /**
     * @param LoginRequest $request
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder
     * @throws AuthenticationException
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if(auth()->attempt($credentials))
        {
            $token = auth()->user()->generateToken()->accessToken;

            return responder()->success(['token' => $token]);
        }

        throw new AuthenticationException();

    }
}
