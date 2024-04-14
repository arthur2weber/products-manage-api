<?php

namespace App\Observers;

use App\Models\ProductModel;

class UserObserver
{
    /**
     * Handle the ProductModel "created" event.
     */
    public function created(ProductModel $productModel): void
    {
        //
    }

    /**
     * Handle the ProductModel "updated" event.
     */
    public function updated(ProductModel $productModel): void
    {
        //
    }

    /**
     * Handle the ProductModel "deleted" event.
     */
    public function deleted(ProductModel $productModel): void
    {
        //
    }

    /**
     * Handle the ProductModel "restored" event.
     */
    public function restored(ProductModel $productModel): void
    {
        //
    }

    /**
     * Handle the ProductModel "force deleted" event.
     */
    public function forceDeleted(ProductModel $productModel): void
    {
        //
    }
}
