<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use Illuminate\Auth\AuthenticationException;
use App\Http\Controllers\Controller;
use JWTAuth;

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
        if(! $token = JWTAuth::attempt($credentials))
        {
            throw new AuthenticationException();
        }

        return responder()->success(['token' => $token]);
    }
}
