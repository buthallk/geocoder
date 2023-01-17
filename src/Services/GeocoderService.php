<?php

namespace Geocoder\Services;

use Geocoder\Resolvers\GeocoderResolverInterface;
use Geocoder\Geocoder\GeocoderInterface;

class GeocoderService implements GeocoderServiceInterface
{
    public function __construct(
        private readonly CityServiceInterface $cityService,
        private readonly GeocoderResolverInterface $geocoderResolver
    ) {
    }

    public function getGeocoderFromCity(): GeocoderInterface
    {
        return $this->geocoderResolver->getGeocoderByType($this->cityService->getCity()->getGeocoderType());
    }
}
