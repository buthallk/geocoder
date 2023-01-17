<?php

namespace Geocoder\Geocoder;

use Geocoder\DTO\GeoCodeAddressDtoInterface;
use Geocoder\DTO\GeoCodeDtoInterface;
use Geocoder\DTO\GoogleGeoCodeDTO;
use Geocoder\Enums\GeocoderType;

class GoogleGeocoder extends Geocoder implements GeocoderInterface
{
    public const GEO_API_KEY = 'https://maps.googleapis.com/maps/api/geocode/json?';
    public const CACHE_KEY = 'googleGeocoderDatabase';
    //seconds
    public const CACHE_TTL = 0;

    protected function getQuery(GeoCodeAddressDtoInterface $address): string
    {
        return self::GEO_API_KEY . 'address=' . $address->getAddressForGeoCode() .
            '&key=' . config('Geocoder.geo_api_key') . '&language=ru';
    }

    public function getGeoCodeData(?array $geoCodeResponse): ?GeoCodeDtoInterface
    {
        $geoCode = $geoCodeResponse['results'] ?? null;
        return $geoCode ? new GoogleGeoCodeDTO(head($geoCode)) : null;
    }

    public function canHandle(string $geocoderType): bool
    {
        return $geocoderType === GeocoderType::GOOGLE->value;
    }

    public function getCountRequest(): int
    {
        return 0;
    }
}
