<?php

namespace App\Repositories;

use App\Filters\FilterTrait;
use App\User as UserModel;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    use FilterTrait;

    public $pathFilter = 'App\\Filters\\Filter\\Users\\';

    public function model()
    {
        return UserModel::class;
    }

    public function test()
    {
        // TODO: Implement test() method.
    }

    public function testSearch($params = [])
    {
        $query = $this->makeModel()->select(['*']);
        $query = $this->search($query, $params);
        return $query->get();
    }
}
