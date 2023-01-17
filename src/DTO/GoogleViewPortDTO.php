<?php

namespace App\DTO;

use OpenApi\Attributes as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

#[SWG\Schema(
    title: "Google view port resource",
    required: [
        "northeast",
        "southwest"
    ],
    type: "object"
)]
class GoogleViewPortDTO implements \JsonSerializable
{
    #[SWG\Property(
        schema: LocationDTO::class,
        description: 'View por northeast'
    )]
    #[Groups(["swagger"])]
    public ?LocationDTO $northeast = null;

    #[SWG\Property(
        schema: LocationDTO::class,
        description: 'View por southwest'
    )]
    #[Groups(["swagger"])]
    public ?LocationDTO $southwest = null;

    public function __construct(array $viewPort)
    {
        $this->northeast = ($northeast = $viewPort['northeast'])? new LocationDTO($northeast) : null;
        $this->southwest = ($southwest = $viewPort['southwest']) ? new LocationDTO($southwest) : null;
    }

    public function jsonSerialize(): array
    {
        return
        [
            'northeast' => $this->northeast,
            'southwest' => $this->southwest
        ];
    }
}
