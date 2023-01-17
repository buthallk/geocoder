<?php

namespace App\Geocoder;

use App\DTO\GeoCodeAddressDtoInterface;
use App\DTO\GeoCodeDtoInterface;

interface GeocoderInterface
{
    public function addressToGPS(GeoCodeAddressDtoInterface $address): ?GeoCodeDtoInterface;
    public function canHandle(string $geocoderType): bool;
    public function getGeoCodeData(?array $geoCodeResponse): ?GeoCodeDtoInterface;
    public function getCache(GeoCodeAddressDtoInterface $geoCodeAddress): mixed;
    public function getCountRequest(): int;
}
