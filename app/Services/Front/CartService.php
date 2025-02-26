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
}
