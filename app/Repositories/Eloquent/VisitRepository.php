<?php
/**
 * Created by PhpStorm.
 * User: Laptop
 * Date: 3/28/2017
 * Time: 8:33 AM
 */

namespace App\Repositories\Eloquent;


use App\Models\Garage;
use App\Models\Visit;
use App\Repositories\Contracts\VisitRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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

    /**
     * @param $key
     * @param $visitableType
     * @return mixed
     */
    public function searchOnInstance($key, $visitableType)
    {
        $newQuery = $this->model->query();
        if ($visitableType === get_class(new Garage())) {
            $newQuery->leftjoin('garages', 'garages.id', 'visits.visitable_id')
                ->where('visits.user_id', Auth::user()->id)
                ->where('visits.visitable_type', $visitableType)
                ->where('is_latest', 1)
                ->where(function ($query) use ($key) {
                    $query->where('garages.name', 'like', '%' . $key . '%')
                        ->orWhere('garages.short_description', 'like', '%' . $key . '%');
                })
                ->select('visits.*');
        } else {
            $newQuery->leftjoin('articles', 'articles.id', 'visits.visitable_id')
                ->where('visits.user_id', Auth::user()->id)
                ->where('visits.visitable_type', $visitableType)
                ->where('is_latest', 1)
                ->where(function ($query) use ($key) {
                    $query->where('articles.title', 'like', '%' . $key . '%')
                        ->orWhere('articles.short_description', 'like', '%' . $key . '%');
                })
                ->select('visits.*');
        }

        return $newQuery->get();
    }
}
