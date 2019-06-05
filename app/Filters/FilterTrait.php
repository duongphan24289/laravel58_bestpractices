<?php
namespace App\Filters;
use App\Filters\Exceptions\FilterException;
use Illuminate\Support\Str;

trait FilterTrait {


    /**
     * @param $name
     * @return string
     * @throws FilterException
     */
    public function createFilterDecorator($name)
    {
        $this->existsPath();

        return $this->pathFilter . Str::studly($name);
    }
    private function existsPath()
    {
        if ( ! $this->pathFilter)
        {
            throw new FilterException('Please set the $pathFilter property to your filter path.');
        }
    }

    /**
     * Check decorator
     *
     * @param $decorator
     * @return bool
     */
    public function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    public function search($query, array $params)
    {
        foreach ($params as $filterName => $value) {
            $decorator = $this->createFilterDecorator($filterName);

            if ($this->isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }
        }
        return $query;
    }
}
