<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
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

    public function index(){

        // if success
         return $this->success([]);

        // if failure
        $errorCode = 400;
        $errorMessage = 'Parameters request is invalid.';
        return $this->error($errorCode, $errorMessage)->respond($errorCode);
    }
}
