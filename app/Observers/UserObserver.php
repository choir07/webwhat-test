<?php

namespace App\Observers;

use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class UserObserver
{
    public function created(User $user)
    {
        activity('User Management')
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties([
                'name' => $user->name,
                'email' => $user->email,
            ])
            ->log("Created user: {$user->name}");
    }

    public function updated(User $user)
    {
        $changes = $user->getChanges();
        
        activity('User Management')
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties([
                'changes' => $changes,
                'name' => $user->name,
            ])
            ->log("Updated user: {$user->name}");
    }

    public function deleted(User $user)
    {
        activity('User Management')
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties([
                'deleted_user' => $user->name,
                'email' => $user->email,
            ])
            ->log("Deleted user: {$user->name}");
    }
}