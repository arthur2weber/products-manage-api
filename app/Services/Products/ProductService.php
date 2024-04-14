<?php

namespace App\Services\Products;

use App\Enums\CacheKeysEnum;
use App\Enums\CacheTtlEnum;
use App\Repositories\Products\ProductRepositoryContract;
use App\Services\Service;

class ProductService extends Service implements ProductServiceContract
{
    public function __construct(
        ProductRepositoryContract $repository
    ) {
        $this->repository = $repository;
    }

    public function allCached(): ?array
    {
        return cache()->remember(
            CacheKeysEnum::PRODUCTS_ALL->value,
            CacheTtlEnum::TTL_MAX->value,
            fn () => $this->repository->all()
        );
    }

    public function findCached(int $id): ?array
    {
        return cache()->remember(
            CacheKeysEnum::PRODUCTS_FIND_ID->valueWith([$id]),
            CacheTtlEnum::TTL_MAX->value,
            fn () => $this->repository->find($id)
        );
    }
}
