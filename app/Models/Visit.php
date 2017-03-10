<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'visitable_type', 'visitable_id'];

    /**
     * Get all of the owning visitable models.
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function visitable()
    {
        return $this->morphTo();
    }

    /**
     * Get user who visited.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
