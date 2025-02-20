<?php

namespace App\Transformers\Api\Front\Address;

use League\Fractal\TransformerAbstract;
use App\Models\Addresses;

class AddressTransformer extends TransformerAbstract
{
    public function transform(Addresses $address)
    {
        return [
            'governorate_id' => $address->governorate_id,
            'city_id' => $address->city_id,
        ];
    }
}
