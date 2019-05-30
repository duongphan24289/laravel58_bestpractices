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
        return $this->user->save($data);
    }
}
