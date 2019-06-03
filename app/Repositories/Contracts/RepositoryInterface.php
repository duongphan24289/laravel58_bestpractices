<?php
namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    /**
     * Retrieve data array for populate field select
     *
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function lists($column, $key = null);

    public function pluck($column, $key = null);

    public function all($columns = ['*']);

    public function paginate($limit = null, $columns = ['*']);

    public function find($id, $columns = ['*']);

    public function findByField($field, $value, $columns = ['*']);

    public function findWhere(array $where, $columns = ['*']);

    public function findWhereIn($field, array $values, $columns = ['*']);

    public function findWhereNotIn($field, array $values, $columns = ['*']);

    public function create(array $attributes);

    public function update(array $attributes, $id);

    public function updateOrCreate(array $attributes, array $values = []);

    public function delete($id);

    public function orderBy($column, $direction = 'asc');

    public function with($relations);

    public function withCount($relations);

    public function hidden(array $fields);

    public function visible(array $fields);

    public function scopeQuery(\Closure $scope);

    public function resetScope();

    public function getFieldsSearchable();

    public function firstOrNew(array $attributes = []);

    public function firstOrCreate(array $attributes = []);

}