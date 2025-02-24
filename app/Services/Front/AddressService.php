<?php

namespace App\Services\Front;

use App\Models\{Addresses, Cities, Governorates, User};

class AddressService
{
    public function getGovernorates()
    {
        $governorates = Governorates::all();
        return $governorates;
    }
    public function getCitiesByGovernorate_Id($governorate_id)
    {
        $cities = Cities::where('governorate_id', $governorate_id)->get();
        return $cities;
    }

    public function getAddressesByUserId($userId)
    {
        $cities = Addresses::where('user_id', $userId)->get();
        return $cities;
    }
    public function createAddress($data)
    {
        $address = Addresses::create($data);
        return $address;
    }
}
