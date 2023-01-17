<?php

namespace Geocoder\Services;

interface CityServiceInterface
{
    public function getCity(): mixed;
    public function getSubdomain(): string;
}