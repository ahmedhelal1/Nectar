<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Front\CartService;
use App\Transformers\Api\Front\Cart\CartTransformer;
use League\Fractal\Resource\Collection;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}
    public function getCart()
    {
        $user = Auth::user()->id;
        $cart = $this->cartService->getCart($user);
        $data = fractal()->collection($cart)->transformWith(new CartTransformer)->toArray();
        return $this->responseApi($data);
    }
}
