<?php

namespace App\DTO;

interface GeoCodeAddressDtoInterface
{
    public function getAddressDTO(): AddressDTO;
    public function getAddressForGeoCode(): string;
    public function getAddressCacheKey(): string;
}
