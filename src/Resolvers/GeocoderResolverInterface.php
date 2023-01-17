<?php

namespace Geocoder\Resolvers;

use \Geocoder\Geocoder\GeocoderInterface;

interface GeocoderResolverInterface
{
    public function getGeocoderByType(string $geoCoderType): GeocoderInterface;
}
