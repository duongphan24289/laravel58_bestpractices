<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct()
    {
        // TODO
        $this->userService = app(UserService::class);

    }

    public function store(UserRequest $request){
        // TODO
    }
}
