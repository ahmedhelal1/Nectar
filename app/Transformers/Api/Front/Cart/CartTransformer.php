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
            'product' => $cart->product ? $cart->product
                ->only(['name', 'price', 'description', 'image']) : null,
            'quantity' => $cart->quantity
        ];
    }
}
