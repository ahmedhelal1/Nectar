<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Front\CartService;
use App\Transformers\Api\Front\Cart\CartTransformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\item;
use App\Http\Requests\Api\Front\Cart\{AddToCartRequest, RemoveFromCartRequest, UpdateCartQuantityRequest};
use App\Models\Cart;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}
    public function getCart()
    {
        $cart = $this->cartService->getCart();
        if (!$cart) {
            return $this->responseApi(['message' => 'Cart not found']);
        }
        $transformedCart  = fractal()->item($cart, new CartTransformer())->toArray();
        return $this->responseApi('Cart retrieved successfully', $transformedCart['data']);
    }
    public function addToCart(AddToCartRequest $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $cart = $this->cartService->addToCart($product_id, $quantity);
        return $this->responseApi('Product added to cart successfully', $cart, 201);
    }
    public function removeFromCart(RemoveFromCartRequest $request)
    {

        $cart_id = $request->cart_id;
        if (!$cart_id) {
            return $this->responseApi('Invalid cart id');
        }
        $this->cartService->removeFromCart($cart_id);
        return $this->responseApi('Product removed from cart successfully');
    }
    public function updateCartQuantity(UpdateCartQuantityRequest $request)
    {

        $data = $this->cartService->updateCartQuantity($request);
        return $this->responseApi("quantity " . $request->action . " is succuss", $data);
    }
}
