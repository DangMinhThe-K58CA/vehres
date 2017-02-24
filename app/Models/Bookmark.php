<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    /**
     * Get all models owning.
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function bookmarkable()
    {
        return $this->morphTo();
    }

    /**
     * Get user who had created.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
