<?php

namespace Geocoder\DTO;

use Geocoder\Enums\CompanyAddress;
use Geocoder\Polygon\Geometry\Point;
use Spatie\DataTransferObject\DataTransferObject;

class YandexGeoCodeDto extends DataTransferObject implements GeoCodeDtoInterface
{
    public array $response = [];

    public function getType(): ?string
    {
        $type = null;
        $components = $this->getComponents();

        if($components)
        {
            $lastAddressComponents = end($components);
            $type = $lastAddressComponents['kind'] ?? null;
        }

        return $type;
    }

    public function getPostalCode(): ?string
    {
        $address = $this->getAddress();
        $postalCode = null;

        if($address)
        {
            $postalCode = $address['postal_code'] ?? null;
        }

        return  $postalCode;
    }

    public function getPoint(): ?Point
    {
        $point = null;
        $geoObject = $this->getGeoObject();

        if($geoObject)
        {
            $point = $geoObject['Point'] ?? [];
            if($point)
            {
                $position = $point['pos'] ?? null;
                if($position)
                {
                    $coordinates = explode(' ', $position);
                    $point = new Point($coordinates[1], $coordinates[0]);
                }
            }
        }

        return $point;
    }

    private function getComponents(): array
    {
        $components = [];
        $address = $this->getAddress();

        if($address)
        {
            $components = $address['Components'] ?? [];
        }

        return $components;
    }

    private function getAddress(): array
    {
        $address = [];
        $geoCodeMetaData = $this->getGeoCodeMetaData();

        if($geoCodeMetaData)
        {
            $address = $geoCodeMetaData['Address'] ?? [];
        }

        return $address;
    }

    private function getGeoCodeMetaData(): array
    {
        $geoCodeMetaData = [];
        $geoObject = $this->getGeoObject();
        if($geoObject)
        {
            $metaDataProperty = $geoObject['metaDataProperty'] ?? [];
            if($metaDataProperty)
            {
                $geoCodeMetaData = $metaDataProperty['GeocoderMetaData'] ?? [];
            }
        }

        return $geoCodeMetaData;
    }

    private function getGeoObject(): array
    {
        $geoObject = [];
        $featureMember = $this->response['GeoObjectCollection']['featureMember'] ?? [];

        if($featureMember)
        {
            $geoObject = $featureMember[0]['GeoObject'] ?? [];
        }

        return $geoObject;
    }

    public function getLat(): ?float
    {
        return $this->getPoint()?->x;
    }

    public function getLng(): ?float
    {
        return $this->getPoint()?->y;
    }

    public function isSuitableAddress(?AddressDTO $address = null): bool
    {
        return $this->getType() === CompanyAddress::HOUSE->value;
    }
}
