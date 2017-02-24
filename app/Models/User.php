<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'description', 'avatar'];

    /**
     * Get garages which created by user.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function garages()
    {
        return $this->hasMany(Garage::class);
    }

    /**
     * Get all visited garages or posts.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Get all distinctly visited garages or posts.
     * @return mixed
     */
    public function distinctVisits()
    {
        return $this->visits()->where('is_latest', 1)->orderBy('created_at', 'desc');
    }

    /**
     * Get all articles which created by user.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get all bookmarks.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Accessor for avatar full path.
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        $avaPrefix = '/uploads/images/users/avatar/';
        return $avaPrefix . $value;
    }

    /**
     * Check given current password.
     * @param $curPass
     * @return mixed
     */
    public function isCorrectCurrentPassword($curPass)
    {
        return Hash::check($curPass, $this->getAuthPassword());
    }

    /**
     * Mutator for password.
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

}
