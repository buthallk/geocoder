<?php

namespace Geocoder\DTO;

use Geocoder\Enums\CompanyAddress;

class GeoCodeAddressDto implements GeoCodeAddressDtoInterface
{
    public function __construct(private readonly AddressDTO $addressDTO)
    {
    }

    public function getAddressDTO(): AddressDTO
    {
        return $this->addressDTO;
    }

    public function getAddressForGeoCode(): string
    {
        $location = [];

        if($address = $this->addressDTO->address) {
            $location[] = $address;
        }

        if($homeNumber = $this->addressDTO->homeNumber) {
            $location[] = $homeNumber;
        }

        if ($this->addressDTO->building) {
            $location[] = $this->addressDTO->building;
        }

        return implode(', ', $location);
    }

    public function getAddressCacheKey(): string
    {
        return CompanyAddress::COMPANY_ADDRESS_CACHE_KEY->value . $this->getAddressForGeoCode();
    }
}
