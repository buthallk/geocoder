<?php

namespace Geocoder\Factories;

use Geocoder\DTO\AddressDTO;
use Geocoder\DTO\GeoCodeAddressDto;

interface GeoCodeAddressFactoryInterface
{
    public function createGeoCodeAddress(AddressDTO $addressDTO): GeoCodeAddressDto;
}
