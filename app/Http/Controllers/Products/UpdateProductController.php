<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Services\Products\ProductServiceContract;

class UpdateProductController extends Controller
{
    public function __construct(
        private ProductServiceContract $service
    ) {
    }

    public function __invoke(int $id, UpdateProductRequest $request)
    {
        $data = $request->validated();

        $register = $this->service->update($id, $data);

        return Response($register);
    }
}
