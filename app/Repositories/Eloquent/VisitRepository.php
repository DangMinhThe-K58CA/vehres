<?php
/**
 * Created by PhpStorm.
 * User: Laptop
 * Date: 3/28/2017
 * Time: 8:33 AM
 */

namespace App\Repositories\Eloquent;


use App\Models\Visit;
use App\Repositories\Contracts\VisitRepositoryInterface;

class VisitRepository extends Repository implements VisitRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Visit::class;
    }
}
