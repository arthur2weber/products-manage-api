<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Services\Products\ProductServiceContract;

class ListProductController extends Controller
{
    public function __construct(
        private ProductServiceContract $service
    ) {
    }

    public function __invoke()
    {
        return Response($this->service->allCached());
    }
}
