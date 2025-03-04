<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\CategoryService;
use App\Transformers\Api\Front\Categories\CategoriesTransformer;
use League\Fractal\Resource\Collection;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $category_Service) {}
    public function index()
    {
        $category = $this->category_Service->index();
        $data = fractal()->collection($category)->transformWith(new CategoriesTransformer)->toArray();
        return $this->responseApi($data, 200);
    }
}
