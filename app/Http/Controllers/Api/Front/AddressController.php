<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\AddressService;
use League\Fractal\Resource\Collection;
use App\Transformers\Api\Front\Address\{AddressTransformer, CityTransformer, GovernmentTransformer};
use App\Http\Requests\Api\Front\Address\CreateAddressRequest;

class AddressController extends Controller
{
    public function __construct(private AddressService $address_service) {}
    public function getGovernorates()
    {

        $governorates = $this->address_service->getGovernorates();
        $governorates = fractal()->collection($governorates)->transformWith(new GovernmentTransformer())->toArray();
        return $this->responseApi('Governorates retrieved successfully', $governorates, 200);
    }

    public function getCities(Request $request)
    {
        $governorateId = $request->input('filter.governorate_id');
        $cities = $this->address_service->getCities($governorateId);
        $cities = fractal()->collection($cities)->transformWith(new CityTransformer())->toArray();
        return $this->responseApi('Get all cities success', $cities, 200);
    }

    public function getAddress(Request $request)
    {

        $userId = auth()->id();
        $address = $this->address_service->getAddress($userId)->load(['governorates', 'cities']);
        $address =  Fractal()
            ->collection($address)
            ->transformWith(new AddressTransformer())
            ->toArray();

        return $this->responseApi('Get address success', $address, 200);
    }

    public function store(CreateAddressRequest $request)
    {
        $data = $request->validated();
        $address = $this->address_service->store($data);
        return $this->responseApi('Address created successfully', $address, 201);
    }
}
