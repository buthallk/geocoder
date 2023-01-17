<?php

namespace Geocoder\DTO;

use Geocoder\Enums\CompanyAddress;
use Spatie\DataTransferObject\DataTransferObject;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Attributes as SWG;

#[SWG\Schema(
    title: "Address resource",
    required:
    [
        "address",
        "building",
        "entrance",
        "intercom",
        "floor",
        "apartment",
        "comment"
    ],
    type: "object"
)]
class AddressDTO extends DataTransferObject
{
    #[SWG\Property(
        description: 'Address',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $address = null;

    public ?string $homeNumber = null;

    #[SWG\Property(
        description: 'Building',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $building = null;

    #[SWG\Property(
        description: 'Entrance',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $entrance = null;

    #[SWG\Property(
        description: 'Intercom',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $intercom = null;

    #[SWG\Property(
        description: 'Floor',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $floor = null;

    #[SWG\Property(
        description: 'Apartment',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $apartment = null;

    #[SWG\Property(
        description: 'Comment',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $comment = null;

    public function getAddressCacheKey(): string
    {
        $location = [$this->address, $this->homeNumber];

        if ($this->building) {
            $location[] = $this->building;
        }

        return CompanyAddress::COMPANY_ADDRESS_CACHE_KEY->value. implode(', ', $location);
    }

    public function toArray(): array
    {
        return
            [
                'address' => $this->address,
                'homeNumber' => $this->homeNumber,
                'building' => $this->building,
                'entrance' => $this->entrance,
                'intercom' => $this->intercom,
                'floor' => $this->floor,
                'apartment' => $this->apartment,
                'comment' => $this->comment,
            ];
    }

    public function __toString(): string
    {
        return implode(', ', array_filter($this->toArray(), fn ($field) => !empty($field)));
    }
}
