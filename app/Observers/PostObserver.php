<?php

namespace App\Observers;

use App\Models\Post;
use Spatie\Activitylog\Models\Activity;

class PostObserver
{
    public function created(Post $post)
    {
        activity('Content Management')
            ->performedOn($post)
            ->causedBy(auth()->user())
            ->withProperties([
                'title' => $post->title,
                'status' => $post->status,
            ])
            ->log("Created post: {$post->title}");
    }

    public function updated(Post $post)
    {
        $changes = $post->getChanges();
        
        activity('Content Management')
            ->performedOn($post)
            ->causedBy(auth()->user())
            ->withProperties([
                'changes' => $changes,
                'title' => $post->title,
            ])
            ->log("Updated post: {$post->title}");
    }

    public function deleted(Post $post)
    {
        activity('Content Management')
            ->performedOn($post)
            ->causedBy(auth()->user())
            ->withProperties([
                'deleted_post' => $post->title,
            ])
            ->log("Deleted post: {$post->title}");
    }
}