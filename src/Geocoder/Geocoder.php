<?php

namespace Geocoder\Geocoder;

use Geocoder\DTO\GeoCodeAddressDtoInterface;
use Geocoder\DTO\GeoCodeDtoInterface;
use Geocoder\Enums\GeocoderType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class Geocoder
{
    public function addressToGPS(GeoCodeAddressDtoInterface $geoCodeAddress): ?GeoCodeDtoInterface
    {
        $geoCodeResponse = Http::get($this->getQuery($geoCodeAddress))->json();
        $geoCodeData = $this->getGeoCodeData($geoCodeResponse);

        $isYandexGeoCode = $this instanceof YandexGeocoder;
        $addressDto = $geoCodeAddress->getAddressDTO();

        $isSuitableAddress = $geoCodeData && $geoCodeData->isSuitableAddress($addressDto);
        $address = $geoCodeAddress->getAddressForGeoCode();

        Log::info(
            "#geocoder Current geocoder for address: $address, cache key: {$geoCodeAddress->getAddressCacheKey()}, isSuitableAddress: {$isSuitableAddress} " . ucfirst(GeocoderType::getTypeByClass(get_class($this))->name)
        );

        if (!$isSuitableAddress && !$isYandexGeoCode)
        {
            throw new \RuntimeException("Google geocoder couldn't find the address: " . $address);
        }
        elseif (!$isSuitableAddress && $isYandexGeoCode)
        {
            throw new \RuntimeException("Yandex geocoder couldn't find the address: $address");
        }

        if ($geoCodeResponse) {
            $this->putCache($geoCodeAddress, $geoCodeResponse);
        }

        return $geoCodeData;
    }

    protected function putCache(GeoCodeAddressDtoInterface $geoCodeAddress, array $geoCodeResponse): void
    {
        $ttl = static::CACHE_TTL !== 0 ? static::CACHE_TTL : null;
        Cache::store(static::CACHE_KEY)->put($geoCodeAddress->getAddressCacheKey(), $geoCodeResponse, $ttl);
    }

    public function getCache(GeoCodeAddressDtoInterface $geoCodeAddress): mixed
    {
        return Cache::store(static::CACHE_KEY)->get($geoCodeAddress->getAddressCacheKey());
    }

    abstract protected function getQuery(GeoCodeAddressDtoInterface $address): string;
    abstract public function getGeoCodeData(?array $geoCodeResponse): ?GeoCodeDtoInterface;
}
