<?php

namespace Geocoder\DTO;

use JsonSerializable;
use OpenApi\Attributes as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

#[SWG\Schema(title: "google geometry resource", required: ["location", "locationType", "viewport"], type: "object")]
class GoogleGeometryDTO implements JsonSerializable
{
    #[SWG\Property(
        schema: LocationDTO::class,
        description: 'Location model'
    )]
    #[Groups(["swagger"])]
    public LocationDTO $location;

    #[SWG\Property(
        description: 'Address component types',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $locationType = null;

    #[SWG\Property(
        schema: GoogleViewPortDTO::class,
        description: 'Location model'
    )]
    #[Groups(["swagger"])]
    public ?GoogleViewPortDTO $viewport = null;

    public function __construct(array $geometryData)
    {
        $this->location = ($location = $geometryData['location'] ?? null) ?
            new LocationDTO($location) : null;
        $this->locationType = $geometryData['location_type'] ?? null;
        $this->viewport = ($viewport = $geometryData['viewport'] ?? null) ? new GoogleViewPortDTO($viewport) : null;
    }

    public function jsonSerialize(): array
    {
        return
        [
            'location' => $this->location,
            'locationType' => $this->locationType,
            'viewport' => $this->viewport
        ];
    }
}
