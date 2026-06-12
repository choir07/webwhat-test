<?php

namespace App\Observers;

use App\Models\Category;
use Spatie\Activitylog\Models\Activity;

class CategoryObserver
{
    public function created(Category $category)
    {
        activity('Content Management')
            ->performedOn($category)
            ->causedBy(auth()->user())
            ->withProperties([
                'name' => $category->name,
            ])
            ->log("Created category: {$category->name}");
    }

    public function updated(Category $category)
    {
        $changes = $category->getChanges();
        
        activity('Content Management')
            ->performedOn($category)
            ->causedBy(auth()->user())
            ->withProperties([
                'changes' => $changes,
                'name' => $category->name,
            ])
            ->log("Updated category: {$category->name}");
    }

    public function deleted(Category $category)
    {
        activity('Content Management')
            ->performedOn($category)
            ->causedBy(auth()->user())
            ->withProperties([
                'deleted_category' => $category->name,
            ])
            ->log("Deleted category: {$category->name}");
    }
}