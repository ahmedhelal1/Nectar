<?php

namespace App\Services\Front;

use Illuminate\Support\Facades\Validator;

use App\Models\{Addresses, Cities, Governorates, User, Categories, Products};
use Illuminate\Http\UploadedFile;

class ProductService
{
    public function index($category_id)
    {
        $product = Products::where('category_id', $category_id)->get();
        return $product;
    }
    public function createProduct(array $data)
    {
        $product = Products::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'category_id' => $data['category_id'],
        ]);
        if (isset($data['image'])) {
            $product->addMedia($data['image'])->toMediaCollection('images');
        }
        $product->save();
        return $product;
    }
    public function getProduct($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return $product;
    }
}
