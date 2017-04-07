<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'title',
        'short_description',
        'content',
        'user_id',
        'avatar',
    ];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get full path for avatar.
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return config('common.path.image') . '/' . $value;
    }
}
