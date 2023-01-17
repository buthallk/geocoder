<?php

namespace Geocoder\Services;

use Geocoder\Geocoder\GeocoderInterface;

interface GeocoderServiceInterface
{
    public function getGeocoderFromCity(): GeocoderInterface;
}