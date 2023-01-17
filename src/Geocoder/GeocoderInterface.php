<?php

namespace Geocoder\Geocoder;

use Geocoder\DTO\GeoCodeAddressDtoInterface;
use Geocoder\DTO\GeoCodeDtoInterface;

interface GeocoderInterface
{
    public function addressToGPS(GeoCodeAddressDtoInterface $address): ?GeoCodeDtoInterface;
    public function canHandle(string $geocoderType): bool;
    public function getGeoCodeData(?array $geoCodeResponse): ?GeoCodeDtoInterface;
    public function getCache(GeoCodeAddressDtoInterface $geoCodeAddress): mixed;
    public function getCountRequest(): int;
}
