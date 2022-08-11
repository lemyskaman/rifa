<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Raffle;
use Illuminate\Auth\Access\HandlesAuthorization;

class RafflePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the raffle can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list raffles');
    }

    /**
     * Determine whether the raffle can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Raffle  $model
     * @return mixed
     */
    public function view(User $user, Raffle $model)
    {
        return $user->hasPermissionTo('view raffles');
    }

    /**
     * Determine whether the raffle can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create raffles');
    }

    /**
     * Determine whether the raffle can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Raffle  $model
     * @return mixed
     */
    public function update(User $user, Raffle $model)
    {
        return $user->hasPermissionTo('update raffles');
    }

    /**
     * Determine whether the raffle can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Raffle  $model
     * @return mixed
     */
    public function delete(User $user, Raffle $model)
    {
        return $user->hasPermissionTo('delete raffles');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Raffle  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete raffles');
    }

    /**
     * Determine whether the raffle can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Raffle  $model
     * @return mixed
     */
    public function restore(User $user, Raffle $model)
    {
        return false;
    }

    /**
     * Determine whether the raffle can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Raffle  $model
     * @return mixed
     */
    public function forceDelete(User $user, Raffle $model)
    {
        return false;
    }
}
