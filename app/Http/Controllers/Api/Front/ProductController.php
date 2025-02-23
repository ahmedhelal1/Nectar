<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\ProductService;
use App\Transformers\Api\Front\Products\ProductsTransformer;
use League\Fractal\Resource\Collection;

class ProductController extends Controller
{
    public function __construct(private ProductService $Product_service) {}
    public function index()
    {
        $Product = $this->Product_service->getProduct();
        $data = fractal()->collection($Product)->transformWith(new ProductsTransformer)->toArray();
        return $this->responseApi($data, 200);
    }
}
