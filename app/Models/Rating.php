<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['user_id', 'garage_id', 'score'];
    /**
     * Get user who had rated.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get garage which rated.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }
}
