<?php

namespace App\Transformers\Api\Front\Address;

use League\Fractal\TransformerAbstract;
use App\Models\Governorates;


class GovernmentTransformer extends TransformerAbstract
{
    public function transform(Governorates $governorates)
    {
        return [
            'id' => (int) $governorates->id,
            'name' => $governorates->name,
        ];
    }
}
