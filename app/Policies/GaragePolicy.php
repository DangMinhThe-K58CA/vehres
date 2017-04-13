<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Garage;
use Illuminate\Auth\Access\HandlesAuthorization;

class GaragePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the garage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Garage  $garage
     * @return mixed
     */
    public function view(User $user, Garage $garage)
    {
        return $user->id === $garage->user_id;
    }

    /**
     * Determine whether the user can create garages.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role === config('common.user.role.partner');
    }

    /**
     * Determine whether the user can update the garage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Garage  $garage
     * @return mixed
     */
    public function update(User $user, Garage $garage)
    {
        return $user->id === $garage->user_id;
    }

    /**
     * Determine whether the user can delete the garage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Garage  $garage
     * @return mixed
     */
    public function delete(User $user, Garage $garage)
    {
        return $user->role === config('common.user.role.admin');
    }
}
