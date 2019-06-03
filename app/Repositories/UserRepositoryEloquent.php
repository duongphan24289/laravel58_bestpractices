<?php

namespace App\Repositories;

use App\User as UserModel;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    public function model()
    {
        return UserModel::class;
    }

    public function test()
    {
        // TODO: Implement test() method.
    }
}