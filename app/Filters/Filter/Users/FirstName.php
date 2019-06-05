<?php
namespace App\Filters\Filter\Users;


use App\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class FirstName implements FilterInterface {

    public static function apply(Builder $builder, $value)
    {
        // TODO: Implement apply() method.
        return $builder->where('first_name', 'LIKE', "%{$value}%");
    }
}
