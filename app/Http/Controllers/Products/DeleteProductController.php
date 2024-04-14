<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Services\Products\ProductServiceContract;

class DeleteProductController extends Controller
{
    public function __construct(
        private ProductServiceContract $service
    ) {
    }

    public function __invoke(int $id)
    {
        return Response($this->service->delete($id));
    }
}
