<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\RepositoryException;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * @var \Closure
     */
    protected $scopeQuery = null;

    /**
     * BaseRepository constructor.
     *
     * @param Application $app
     * @throws RepositoryException
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
        $this->boot();
    }

    /**
     *
     */
    public function boot()
    {
        //
    }

    /**
     * @throws RepositoryException
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if(!$model instanceof Model)
        {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    abstract public function model();

    public function lists($column, $key = null)
    {
        return $this->model->lists($column, $key);
    }

    public function all($columns = ['*'])
    {
        $this->applyScope();
        if($this->model instanceof Builder)
        {
            $results = $this->model->get($columns);
        }
        else {
            $results = $this->model->all($columns);
        }

        $this->resetModel();
        $this->resetScope();

        return $results;
    }

    public function pluck($column, $key = null)
    {
        return $this->model->pluck($column, $key);
    }

    /**
     * @param null $limit
     * @param array $columns
     * @param string $method
     * @throws RepositoryException
     */
    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        $this->applyScope();
        $limit = is_null($limit) ? config('repository.pagination.limit',15) : $limit;
        $results = $this->model->{$method}($limit, $columns);
        $results->appends(app('request')->query());
        $this->resetModel();

        return $this->parseResult($results);
    }

    public function find($id, $columns = ['*'])
    {
        $this->applyScope();
        $result = $this->model->findOrFail($id, $columns);
        $this->resetModel();
        return $this->parseResult($result);
    }

    public function findByField($field, $value, $columns = ['*'])
    {
        $this->applyScope();
        $result = $this->model->where($field, '=', $value)->get($columns);
        $this->resetModel();

        return $this->parseResult($result);
    }

    public function findWhere(array $where, $columns = ['*'])
    {
        $this->applyScope();
        $this->applyConditions($where);
        $model = $this->model->get($columns);
        $this->resetModel();

        return $this->parseResult($model);
    }

    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        $this->applyScope();
        $model = $this->model->whereIn($field, $values)->get($columns);
        $this->resetModel();

        return $this->parseResult($model);
    }

    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        $this->applyScope();
        $model = $this->model->whereNotIn($field, $values)->get($columns);
        $this->resetModel();

        return $this->parseResult($model);
    }

    public function create(array $attributes)
    {
        $this->applyScope();
        $model = $this->model->newInstance($attributes);
        $model->save();
        $this->resetModel();

        return $this->parseResult($model);
    }

    public function update(array $attributes, $id)
    {
        $this->applyScope();
        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();
        $this->resetModel();

        return $this->parseResult($model);
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        $this->applyScope();
        $model = $this->model->updateOrCreate($attributes, $values);
        $this->resetModel();

        return $this->parseResult($model);
    }

    public function delete($id)
    {
        $this->applyScope();
        $model = $this->find($id);

        $this->resetModel();
        $deleted = $model->delete();

        return $deleted;
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }

    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    public function withCount($relations)
    {
        $this->model = $this->model->withCount($relations);

        return $this;
    }

    public function hidden(array $fields)
    {
        $this->model->setHidden($fields);

        return $this;
    }

    public function visible(array $fields)
    {
        $this->model->setVisible($fields);

        return $this;
    }

    public function scopeQuery(\Closure $scope)
    {
        $this->scopeQuery = $scope;

        return $this;
    }

    public function resetScope()
    {
        $this->scopeQuery = null;

        return $this;
    }

    protected function applyScope()
    {
        if(isset($this->scopeQuery) && is_callable($this->scopeQuery))
        {
            $callback = $this->scopeQuery;
            $this->model = $callback($this->model);
        }
        return $this;
    }

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function firstOrNew(array $attributes = [])
    {
        $this->applyScope();
        $model = $this->model->firstOrNew($attributes);

        $this->resetModel();

        return $this->parseResult($model);
    }

    public function firstOrCreate(array $attributes = [])
    {
        $this->applyScope();

        $model = $this->model->firstOrCreate($attributes);
        $this->resetModel();

        return $this->parseResult($model);
    }

    protected function applyConditions($where)
    {
        foreach ($where as $field => $value){
            if(is_array($value)){
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            }
            else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    protected function parseResult($result)
    {
        return $result;
    }
}