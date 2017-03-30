<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdministrationUnit extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'parent_id'];

    /**
     * Get parent administration.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(AdministrationUnit::class, 'parent_id');
    }

    /**
     * Get successor administration units.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(AdministrationUnit::class, 'parent_id');
    }
}
