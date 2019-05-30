<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UserRequest;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $user)
    {
        $this->userService = $user;
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $response = $this->userService->create($validated);
        return $this->success($response);
    }
}
