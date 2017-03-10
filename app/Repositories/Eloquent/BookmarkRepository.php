<?php
/**
 * Created by PhpStorm.
 * User: Laptop
 * Date: 3/27/2017
 * Time: 2:36 PM
 */

namespace App\Repositories\Eloquent;


use App\Models\Bookmark;
use App\Repositories\Contracts\BookmarkRepositoryInterface;

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
}
