<?php

namespace Geocoder\Geocoder;

use Geocoder\DTO\GeoCodeAddressDtoInterface;
use Geocoder\DTO\GeoCodeDtoInterface;
use Geocoder\DTO\YandexGeoCodeDto;
use Geocoder\Enums\GeocoderType;
use Illuminate\Support\Facades\Http;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class YandexGeocoder extends Geocoder implements GeocoderInterface
{
    public const GEO_API_KEY = 'https://geocode-maps.yandex.ru/1.x/?';
    public const YANDEX_DEVELOPER_URL = 'https://api-developer.tech.yandex.net/';
    public const CACHE_KEY = 'yandexGeocoderDatabase';

    //seconds
    public const CACHE_TTL = 86400;

    protected function getQuery(GeoCodeAddressDtoInterface $address): string
    {
        return static::GEO_API_KEY  . 'apikey=' . config('geocoder.yandex_geo_api_key') .
            '&geocode=' . $address->getAddressForGeoCode() . '&lang=ru&format=json';
    }

    /**
     * @throws UnknownProperties
     */
    public function getGeoCodeData(?array $geoCodeResponse): ?GeoCodeDtoInterface
    {
        return  $geoCodeResponse ? new YandexGeoCodeDto($geoCodeResponse) : null;
    }

    public function canHandle(string $geocoderType): bool
    {
        return $geocoderType === GeocoderType::YANDEX->value;
    }

    public function getCountRequest(): int
    {
        $result = [];

        $projectResponse = Http::withHeaders(['X-Auth-Key' => config('Geocoder.yandex_developer_key')])
            ->get(static::YANDEX_DEVELOPER_URL . 'projects')->json();

        $projects = $projectResponse['projects'] ?? [];
        $project = $projects ? array_shift($projects) : null;

        $projectId = $project['id'] ?? null;
        if($projectId)
        {
            $serviceResponse = Http::withHeaders(['X-Auth-Key' => config('Geocoder.yandex_developer_key')])
                ->get(static::YANDEX_DEVELOPER_URL . 'projects/' . $projectId . '/services')->json();

            $services = $serviceResponse['services'] ?? null;
            $service = $services ? array_shift($services) : null;

            $serviceId = $service['id'] ?? null;

            $result = $serviceId ?
                Http::withHeaders(['X-Auth-Key' => config('Geocoder.yandex_developer_key')])
                    ->get(static::YANDEX_DEVELOPER_URL . "projects/$projectId/services/$serviceId/limits")
                    ->json() : [];
        }

        $limits = $result['limits'] ?? [];
        $apiMapDaily = $limits['apimaps_total_daily'] ?? [];

        return $apiMapDaily['value'] ?? 0;
    }
}
