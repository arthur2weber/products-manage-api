<?php

namespace App\Services\Products;

use App\Services\ServiceContract;

interface ProductServiceContract extends ServiceContract
{
    public function allCached(): ?array;

    public function findCached(int $id): ?array;
}
