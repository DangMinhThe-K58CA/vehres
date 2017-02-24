<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * Get all visits.
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }

    /**
     * Get all comments.
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
