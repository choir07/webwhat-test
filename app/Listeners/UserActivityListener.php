<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Spatie\Activitylog\Models\Activity;

class UserActivityListener
{
    public function handleLogin(Login $event)
    {
        activity('Authentication')
            ->causedBy($event->user)
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ])
            ->log("User logged in: {$event->user->name}");
    }

    public function handleLogout(Logout $event)
    {
        if ($event->user) {
            activity('Authentication')
                ->causedBy($event->user)
                ->log("User logged out: {$event->user->name}");
        }
    }
}