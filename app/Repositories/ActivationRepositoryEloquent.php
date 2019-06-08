<?php

namespace App\Repositories;

use App\Activation as Model;

class ActivationRepositoryEloquent extends BaseRepository implements ActivationRepository
{
    public function model()
    {
        return Model::class;
    }
}