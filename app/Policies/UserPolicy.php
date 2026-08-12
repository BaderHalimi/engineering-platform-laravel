<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'user']);
    }


    public function update(User $user, User $model): bool
    {
        if ($model->role === 'admin' && $user->role !== 'admin') {
            return false;
        }

        return true;
    }


    public function delete(User $user, User $model): bool
    {
        if ($model->role === 'admin' && $user->role !== 'admin') {
            return false;
        }

        return true;
    }
}
