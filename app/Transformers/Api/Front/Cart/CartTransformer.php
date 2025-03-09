<?php

namespace App\Transformers\Api\Front\Cart;

use League\Fractal\TransformerAbstract;
use App\Models\Cart;


class CartTransformer extends TransformerAbstract
{
    public function transform(Cart $cart)
    {


        return [
            'id' => $cart->id,
            'products' => $cart->products ? $cart->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'description' => $product->description,
                    'image' => $product->image,
                    'quantity' => $product->pivot->quantity ?? 1
                ];
            }) : [],
        ];
    }
}
