<?php
/**
 * Created by PhpStorm.
 * User: Laptop
 * Date: 3/27/2017
 * Time: 2:36 PM
 */

namespace App\Repositories\Eloquent;


use App\Models\Bookmark;
use App\Models\Garage;
use App\Repositories\Contracts\BookmarkRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class BookmarkRepository extends Repository implements BookmarkRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Bookmark::class;
    }

    public function searchOnInstance($key, $bookmarkableType)
    {
//        $this->applyCriteria();
        $newQuery = $this->model->query();
        if ($bookmarkableType === get_class(new Garage())) {
            $newQuery->leftjoin('garages', 'garages.id', 'bookmarks.bookmarkable_id')
                    ->where('bookmarks.user_id', Auth::user()->id)
                    ->where('bookmarks.bookmarkable_type', $bookmarkableType)
                    ->where(function ($query) use ($key) {
                        $query->where('garages.name', 'like', '%' . $key . '%')
                            ->orWhere('garages.short_description', 'like', '%' . $key . '%');
                    })
                    ->select('bookmarks.*');
        } else {
            $newQuery->leftjoin('articles', 'articles.id', 'bookmarks.bookmarkable_id')
                ->where('bookmarks.user_id', Auth::user()->id)
                ->where('bookmarks.bookmarkable_type', $bookmarkableType)
                ->where(function ($query) use ($key) {
                    $query->where('articles.title', 'like', '%' . $key . '%')
                        ->orWhere('articles.short_description', 'like', '%' . $key . '%');
                })
                ->select('bookmarks.*');
        }

        return $newQuery->get();
    }
}
