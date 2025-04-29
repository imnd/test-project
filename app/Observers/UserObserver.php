<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the Commodity "deleted" event.
     */
    public function deleted(User $user): void
    {
        $user->orders()->delete();
    }
}
