<?php

namespace App\Http\Services;

use App\Repositories\UserRepository;

class UserService {

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($data){

        return $this->userRepository->create($data);
    }
}
