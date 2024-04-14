<?php

namespace App\Services\Products;

use App\Repositories\Products\ProductRepositoryContract;
use App\Services\Service;

class ProductService extends Service implements ProductServiceContract
{
    public function __construct(
        ProductRepositoryContract $repository
    ) {
        $this->repository = $repository;
    }
}
