<?php

namespace App\Transformers\Api\Front\Products;

use League\Fractal\TransformerAbstract;
use App\Models\Products;

class ProductsTransformer extends TransformerAbstract
{
    public function transform(Products $products)
    {
        return [
            'name' => $products->name,
            'image' => $products->image,
            'description' => $products->description,
            'price' => $products->price,
            'quantity' => $products->quantity,
            'category' => $products->categories->name,
        ];
    }
}
