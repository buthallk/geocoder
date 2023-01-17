<?php

namespace Geocoder\DTO;

use OpenApi\Attributes as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

#[SWG\Schema(title: "Plus code resource", required: ["compoundCode", "globalCode"], type: "object")]
class PlusCodeDTO implements \JsonSerializable
{
    #[SWG\Property(
        description: 'Compound code',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $compoundCode = null;

    #[SWG\Property(
        description: 'Global code',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $globalCode = null;

    public function __construct(array $locationData)
    {
        $this->compoundCode = $locationData['compound_code'] ?? null;
        $this->globalCode = $locationData['global_code'] ?? null;
    }

    public function jsonSerialize(): array
    {
        return
        [
            'compoundCode' => $this->compoundCode,
            'globalCode' => $this->globalCode
        ];
    }
}
