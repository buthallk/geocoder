<?php

namespace App\Services;

interface CityServiceInterface
{
    public function getCity(): mixed;
    public function getSubdomain(): string;
}