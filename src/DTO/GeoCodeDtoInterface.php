<?php

namespace App\DTO;

use App\Polygon\Geometry\Point;

interface GeoCodeDtoInterface
{
    public function getType():?string;
    public function getPostalCode(): ?string;
    public function getPoint(): ?Point;
    public function isSuitableAddress(?AddressDTO $address = null): bool;
    public function getLat(): ?float;
    public function getLng(): ?float;
}
