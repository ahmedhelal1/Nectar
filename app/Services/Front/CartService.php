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
    public function removeFromCart($id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            $cart->delete();
            return true;
        }
        return false;
    }
    public function updateCartQuantity($data)
    {
        $id = $data->cart_id;
        $action = $data->action;
        $row = Cart::find($id);
        if (!$row) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }
        if ($action == "increase") {
            $row->quantity++;
        } elseif ($action == "decrease" && $row->quantity != 1) {
            $row->quantity--;
        }
        $row->save();
    }
}
