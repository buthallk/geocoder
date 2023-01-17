<?php

namespace Geocoder\DTO;

use OpenApi\Attributes as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

#[SWG\Schema(title: "Location resource", required: ["lat", "lng"], type: "object")]
class LocationDTO implements \JsonSerializable
{
    #[SWG\Property(description: "Location lat", type: "string")]
    #[Groups(["swagger"])]
    public ?string $lat = null;

    #[SWG\Property(description: "Location lng", type: "string")]
    #[Groups(["swagger"])]
    public ?string $lng = null;

    public function __construct(array $locationData)
    {
        $this->lat = $locationData['lat'] ?? null;
        $this->lng = $locationData['lng'] ?? null;
    }

    public function jsonSerialize(): array
    {
        return
        [
            'lat' => $this->lat,
            'lng' => $this->lng
        ];
    }
}
