<?php

namespace App\Http\Services;

use App\User;

class UserService {

    protected $user;

    public function __construct(User $user)
    {
        // TODO
        $this->user = $user;
    }

    public function create($data){

        return $this->user->create($data);
    }

    public function createToken(){
        return $this->user->generateToken();
    }
}
