<?php

namespace App\Transformers\Api\Front\Address;

use League\Fractal\TransformerAbstract;
use App\Models\Cities;


class CityTransformer extends TransformerAbstract
{
    public function transform(Cities $cities)
    {
        return [

            'id' => $cities->id,
            'name' => $cities->name,
        ];
    }
}
