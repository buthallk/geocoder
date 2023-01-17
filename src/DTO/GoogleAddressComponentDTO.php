<?php

namespace App\DTO;

use OpenApi\Attributes as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

#[SWG\Schema(title: "Google address component resource", required: ["longName", "shortName", "types"], type: "object")]
class GoogleAddressComponentDTO implements \JsonSerializable
{
    #[SWG\Property(
        description: 'Address component long name',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $longName = null;

    #[SWG\Property(
        description: 'Address component short name',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $shortName = null;

    #[SWG\Property(
        description: 'Address component types',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $types = null;

    public function __construct(array $addressComponentData)
    {
        $this->longName = $addressComponentData['long_name'] ?? null;
        $this->shortName = $addressComponentData['short_name'] ?? null;
        $this->types = implode(', ', $addressComponentData['types']);
    }

    public function jsonSerialize(): array
    {
        return
        [
            'longName' => $this->longName,
            'shortName' => $this->shortName,
            'types' => $this->types
        ];
    }
}
