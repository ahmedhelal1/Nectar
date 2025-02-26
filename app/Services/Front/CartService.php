<?php

namespace App\Services\Front;


use App\Models\{Products, Cart, User};

class CartService
{
    public function getCart($id)
    {
        $cart = Cart::where('user_id', $id)->get();
        return $cart;
    }
    public function addToCart($product_id, $user_id)
    {
        $cart = Cart::firstOrCreate(['product_id' => $product_id, 'user_id' => $user_id]);
        $cart->quantity++;
        $cart->save();
        return $cart;
    }
}
