<?php

namespace Geocoder\Factories;

use Geocoder\DTO\AddressDTO;
use Geocoder\DTO\GeoCodeAddressDto;
use Geocoder\Services\CityServiceInterface;

class GeoCodeAddressFactory implements GeoCodeAddressFactoryInterface
{
    public const ADDR_HINT_PROVIDER = 'DADATA';

    public function __construct(private readonly CityServiceInterface $cityService)
    {
    }

    public function createGeoCodeAddress(AddressDTO $addressDTO): GeoCodeAddressDto
    {
        if(mb_strtoupper(config('provider.address_hint')) !== static::ADDR_HINT_PROVIDER)
        {
            $city = $this->cityService->getCity();
            $addressDTO->address = 'г.' . $city->getName() . ', ' . $addressDTO->address;
        }

        return new GeoCodeAddressDto($addressDTO);
    }
}
