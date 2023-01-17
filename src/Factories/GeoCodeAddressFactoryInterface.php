<?php

namespace App\Factories;

use App\DTO\AddressDTO;
use App\DTO\GeoCodeAddressDto;

interface GeoCodeAddressFactoryInterface
{
    public function createGeoCodeAddress(AddressDTO $addressDTO): GeoCodeAddressDto;
}
