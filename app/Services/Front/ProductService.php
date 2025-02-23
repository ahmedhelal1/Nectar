<?php

namespace App\Services\Front;

use App\Models\{Addresses, Cities, Governorates, User, Categories, Products};

class ProductService
{
    public function getProduct()
    {
        $product = Products::all();
        return $product;
    }
}
