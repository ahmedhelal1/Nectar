<?php

namespace App\Services\Front;

use App\Models\{Addresses, Cities, Governorates, User, Categories, Products};

class CategoryService
{
    public function index()
    {
        $categories = Categories::all();
        return $categories;
    }
}
