<?php
/**
 * Created by PhpStorm.
 * User: Laptop
 * Date: 3/26/2017
 * Time: 10:59 PM
 */

namespace App\Repositories\Criteria;
use App\Repositories\Contracts\RepositoryInterface as Repository;

class WhereConditionCriteria extends Criteria
{
    protected $key;
    protected $operator;
    protected $value;

    public function __construct($key, $operator, $value)
    {
        $this->key = $key;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function apply($model, Repository $repository)
    {
        // TODO: Implement apply() method.

        $query = $model->where($this->key, $this->operator, $this->value);

        return $query;
    }
}
