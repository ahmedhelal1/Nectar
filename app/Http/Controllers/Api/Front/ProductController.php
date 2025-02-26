<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\ProductService;
use App\Transformers\Api\Front\Products\ProductsTransformer;
use League\Fractal\Resource\Collection;

use App\Http\Requests\Api\Front\Product\CreateProductRequest;

class ProductController extends Controller
{
    public function __construct(private ProductService $Product_service) {}
    public function index(Request $request)
    {
        $category_id = $this->validate($request, [
            'filter.category_id' => 'required|integer',
        ]);
        $Products = $this->Product_service->index($category_id);
        $data = fractal()->collection($Products)->transformWith(new ProductsTransformer)->toArray();
        return $this->responseApi($data, 200);
    }
    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();
        $product = $this->Product_service->createProduct($data);
        return $this->responseApi('Product created successfully', $product, 201);
    }
    public function getProduct(Request $request)
    {
        $product = $this->Product_service->getProduct($request->id);
        $data = fractal()->item($product)->transformWith(new ProductsTransformer)->toArray();
        return $this->responseApi($data);
    }
}
