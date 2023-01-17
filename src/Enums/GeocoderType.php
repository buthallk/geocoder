<?php

namespace Geocoder\Enums;

use Geocoder\Geocoder\YandexGeocoder;

enum GeocoderType: string
{
    case GOOGLE = 'google';
    case YANDEX = 'yandex';

    public static function getTypeByClass(string $className): GeocoderType
    {
        return match ($className)
        {
            YandexGeocoder::class => self::YANDEX,
            default => self::GOOGLE
        };
    }
}
