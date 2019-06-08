<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    protected $table = 'activations';

    protected $primaryKey = 'id';

    protected $hidden = [];

    protected $fillable = [
        'id',
        'user_id',
        'token',
        'created_at',
        'updated_at',
    ];


}
