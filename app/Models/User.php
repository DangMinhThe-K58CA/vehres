<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email', 'password', 'description', 'avatar'];

    /**
     * Get garages which created by user.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function garages()
    {
        return $this->hasMany('App\Models\Garage');
    }

    /**
     * Get all visited garages or posts.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits()
    {
        return $this->hasMany('App\Models\Visit');
    }

    /**
     * Get all distinctly visited garages or posts.
     * @return mixed
     */
    public function distinctVisits()
    {
        return $this->hasMany('App\Models\Visit')->where('is_latest', 1)->orderBy('created_at', 'desc');
    }
    /**
     * Get rating for specific garage.
     * @param $garageId
     * @return mixed
     */
    public function getRatingOnGarage($garageId)
    {
        return $this->hasOne('App\Models\Rating')->where('user_id', $this->id)->where('garage_id', $garageId);
    }

    /**
     * Get all articles which created by user.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}
