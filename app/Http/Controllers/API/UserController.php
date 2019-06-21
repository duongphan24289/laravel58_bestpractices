<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UserRequest;
use App\Http\Services\UserService;
use App\Traits\ActivationTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    use ActivationTrait;

    protected $userService;

    public function __construct(UserService $user)
    {
        $this->userService = $user;
    }

    public function detail($id)
    {
        // TODO
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->create($request->validated());

        $this->initiateEmailActivation($user);

        return responder()->success($user);
    }
}
