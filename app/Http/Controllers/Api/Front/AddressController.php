<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\AddressService;
use App\Traits\Response;
use League\Fractal\Resource\Collection;
use App\Transformers\Api\Front\Address\AddressTransformer;

class AddressController extends Controller
{
    use Response;
    public function __construct(private AddressService $address_service) {}
    public function getGovernorates()
    {

        $governorates = $this->address_service->getGovernorates();
        return $this->responseApi('Governorates retrieved successfully', $governorates, 200);
    }

    public function getCities(Request $request)
    {
        $governorateId = $request->input('filter.governorate_id');
        $cities = $this->address_service->getCitiesBygovernorate_id($governorateId);
        return $this->responseApi('Get all cities success', $cities, 200);
    }

    public function getAddress(Request $request)
    {
        $userId = $request->input('filter.user_id');
        $address = $this->address_service->getAddressesByUserId($userId)->load(['governorates', 'cities']);
        $address =  Fractal()
            ->collection($address)
            ->transformWith(new AddressTransformer())
            ->toArray();

        return $this->responseApi('Get address success', $address, 200);
    }
}
