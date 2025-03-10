<?php

namespace App\Transformers\Api\Front\Address;

use League\Fractal\TransformerAbstract;
use App\Models\Addresses;

class AddressTransformer extends TransformerAbstract
{
    public function transform(Addresses $address)
    {
        return [

            'id' => (int) $address->id,
            'governorate' => $address->governorates->name,
            'city' => $address->cities->name,
        ];
    }
}
