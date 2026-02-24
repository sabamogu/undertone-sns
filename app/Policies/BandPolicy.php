<?php

namespace App\Policies;

use App\Models\Band;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BandPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Band $band): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Band $band): bool
    {
        // 投稿者本人、または管理者（idが1の人など）なら許可
        return $user->id === $band->user_id || $user->id === 1; 
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Band $band): bool
    {
        return $user->id === $band->user_id || $user->id === 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Band $band): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Band $band): bool
    {
        return false;
    }
}
