<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\UserService as PrimaryService;
use Illuminate\Validation\UnauthorizedException;

class PassportController extends Controller
{
    /*
     * UserService
     */
    protected $primaryService;

    public function __construct(
        PrimaryService $primaryService
    )
    {
        $this->primaryService = $primaryService;
    }

    public function store(UserRequest $request)
    {
        $user = $this->primaryService->create($request->validated());

        return responder()->success($user);
    }

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

    /**
     * Get detail user
     *
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder
     */
    public function detail()
    {
        return responder()->success(auth()->user());
    }
}
