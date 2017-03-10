<?php
/**
 * Created by PhpStorm.
 * User: Laptop
 * Date: 3/13/2017
 * Time: 5:22 PM
 */

namespace App\Repositories\Criteria;

use App\Repositories\Contracts\RepositoryInterface as Repository;

class HomeGarageCriteria extends Criteria
{

    public function apply($model, Repository $repository)
    {
        // TODO: Implement apply() method.
        $query = $model->where('status', config('common.garage.status.activated'));

        return $query;
    }
}
