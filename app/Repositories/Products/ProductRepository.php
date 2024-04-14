<?php

namespace App\Repositories\Products;

use App\Models\ProductModel;
use App\Repositories\Repository;

class ProductRepository extends Repository implements ProductRepositoryContract
{
    public function __construct(
        ProductModel $model
    ) {
        $this->model = $model;
    }
}
