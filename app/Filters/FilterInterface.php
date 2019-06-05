<?php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface {
    public static function apply(Builder $builder, $value);
}
