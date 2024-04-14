<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductRequest;
use App\Services\Products\ProductServiceContract;
use Illuminate\Http\Response;

class CreateProductController extends Controller
{
    public function __construct(
        private ProductServiceContract $service
    ) {
    }

    public function __invoke(CreateProductRequest $request)
    {
        $data = $request->validated();

        $register = $this->service->create($data);

        return Response($register, Response::HTTP_CREATED);
    }
}
