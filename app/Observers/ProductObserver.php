<?php

namespace App\Observers;

use App\Models\Product;
use Spatie\Activitylog\Models\Activity;

class ProductObserver
{
    public function created(Product $product)
    {
        activity('Content Management')
            ->performedOn($product)
            ->causedBy(auth()->user())
            ->withProperties([
                'name' => $product->name,
                'price' => $product->price,
                'sku' => $product->sku,
            ])
            ->log("Created product: {$product->name}");
    }

    public function updated(Product $product)
    {
        $changes = $product->getChanges();
        $oldValues = [];
        
        foreach ($changes as $field => $newValue) {
            $oldValues[$field] = $product->getOriginal($field);
        }
        
        activity('Content Management')
            ->performedOn($product)
            ->causedBy(auth()->user())
            ->withProperties([
                'changes' => $changes,
                'old_values' => $oldValues,
                'name' => $product->name,
            ])
            ->log("Updated product: {$product->name}");
    }

    public function deleted(Product $product)
    {
        activity('Content Management')
            ->performedOn($product)
            ->causedBy(auth()->user())
            ->withProperties([
                'deleted_product' => $product->name,
                'sku' => $product->sku,
            ])
            ->log("Deleted product: {$product->name}");
    }
}