<?php

namespace App\Services\Front;


use App\Models\{Products, Cart, User};


class CartService
{
    public function getCart()
    {
        $cart = Cart::where('user_id', auth()->id())->with('products')->first();
        return $cart;
    }


    public function addToCart($product_id, $quantity)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->first();
        if (!$cart) {
            $cart = Cart::create(['user_id' =>  auth()->user()->id]);
        }


        $product = Products::find($product_id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $isExistingProduct = $cart->products()->where('product_id', $product_id)->first();
        if ($isExistingProduct) {

            $cart->products()->updateExistingPivot($product->id, [
                'quantity' => $isExistingProduct->pivot->quantity + $quantity
            ]);
        } else {
            $cart->products()->syncWithoutDetaching([$product->id => ['quantity' => $quantity]]);
        }
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
