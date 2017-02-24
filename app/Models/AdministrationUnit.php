<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrationUnit extends Model
{
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
