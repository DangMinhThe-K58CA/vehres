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

    /**
     * @param $key
     * @param $visitableType
     * @return mixed
     */
    public function searchOnInstance($key, $visitableType)
    {
        $newQuery = $this->model->query();
        if ($visitableType === get_class(new Garage())) {
            $newQuery->leftjoin('garages', 'garages.id', 'bookmarks.visitable_id')
                ->where('bookmarks.user_id', Auth::user()->id)
                ->where('bookmarks.visitable_type', $visitableType)
                ->where(function ($query) use ($key) {
                    $query->where('garages.name', 'like', '%' . $key . '%')
                        ->orWhere('garages.short_description', 'like', '%' . $key . '%');
                })
                ->select('bookmarks.*');
        } else {
            $newQuery->leftjoin('articles', 'articles.id', 'bookmarks.visitable_id')
                ->where('bookmarks.user_id', Auth::user()->id)
                ->where('bookmarks.visitable_type', $visitableType)
                ->where(function ($query) use ($key) {
                    $query->where('articles.title', 'like', '%' . $key . '%')
                        ->orWhere('articles.short_description', 'like', '%' . $key . '%');
                })
                ->select('bookmarks.*');
        }

        return $newQuery->get();
    }
}
