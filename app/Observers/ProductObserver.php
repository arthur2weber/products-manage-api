<?php

namespace App\Observers;

use App\Enums\CacheKeysEnum;
use App\Models\ProductModel;

class ProductObserver
{
    /**
     * Handle the ProductModel any event.
     */
    public function anyEvent(ProductModel $productModel)
    {
        //Cache()->delete(CacheKeysEnum::PRODUCTS_FIND_ID->valueWith($productModel->id));
        Cache()->delete(CacheKeysEnum::PRODUCTS_ALL->value);
    }

    /**
     * Handle the ProductModel "created" event.
     */
    public function created(ProductModel $productModel): void
    {
        $this->anyEvent($productModel);
    }

    /**
     * Handle the ProductModel "updated" event.
     */
    public function updated(ProductModel $productModel): void
    {
        $this->anyEvent($productModel);
    }

    /**
     * Handle the ProductModel "deleted" event.
     */
    public function deleted(ProductModel $productModel): void
    {
        $this->anyEvent($productModel);
    }

    /**
     * Handle the ProductModel "restored" event.
     */
    public function restored(ProductModel $productModel): void
    {
        $this->anyEvent($productModel);
    }

    /**
     * Handle the ProductModel "force deleted" event.
     */
    public function forceDeleted(ProductModel $productModel): void
    {
        $this->anyEvent($productModel);
    }
}
