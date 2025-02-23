<?php

namespace App\Transformers\Api\Front\Categories;

use League\Fractal\TransformerAbstract;
use App\Models\Categories;

class CategoriesTransformer extends TransformerAbstract
{
    public function transform(Categories $categories)
    {
        return [
            'name' => $categories->name,
            'image' => $categories->image,
        ];
    }
}
