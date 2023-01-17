<?php

namespace App\Resolvers;

use \App\Geocoder\GeocoderInterface;

interface GeocoderResolverInterface
{
    public function getGeocoderByType(string $geoCoderType): GeocoderInterface;
}
