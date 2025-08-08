<?php

namespace App\Policies;

use App\Models\Tools;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ToolsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $currentUser = Auth::user();
        if ($currentUser->id == 2) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tools $tools): bool
    {
        $currentUser = Auth::user();
        if ($currentUser->id == 2) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $currentUser = Auth::user();
        if ($currentUser->id == 2) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tools $tools): bool
    {
        $currentUser = Auth::user();
        if ($currentUser->id == 2) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tools $tools): bool
    {
        $currentUser = Auth::user();
        if ($currentUser->id == 2) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tools $tools): bool
    {
        $currentUser = Auth::user();
        if ($currentUser->id == 2) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tools $tools): bool
    {
        $currentUser = Auth::user();
        if ($currentUser->id == 2) {
            return true;
        }
        return false;
    }
}
