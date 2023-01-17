<?php

namespace App\DTO;

use App\Modules\Companies\Enums\CompanyAddress;
use App\Modules\GeoCode\Enums\GeocoderType;
use App\Modules\Polygon\Geometry\Point;
use Illuminate\Support\Facades\Log;
use JsonSerializable;
use OpenApi\Attributes as SWG;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[SWG\Schema(
    title: "Google geo code resource",
    required: [
        "addressComponents",
        "formattedAddress",
        "geometry",
        "placeId",
        "plusCode",
        "types"
    ],
    type: "object"
)]
class GoogleGeoCodeDTO implements JsonSerializable, GeoCodeDtoInterface
{
    #[SWG\Property(
        description: 'Address components',
        type: "array",
        items: new SWG\Items(
            schema: GoogleAddressComponentDTO::class,
            description: "Address component"
        )
    )]
    #[Groups(["swagger"])]
    public array $addressComponents;

    #[SWG\Property(
        description: 'Formatted address',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $formattedAddress = null;

    #[SWG\Property(
        schema: GoogleGeometryDTO::class,
        description: 'Location model'
    )]
    #[Groups(["swagger"])]
    public ?GoogleGeometryDTO $geometry;

    #[SWG\Property(
        description: 'Address component types',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $placeId = null;

    #[SWG\Property(
        schema: GoogleViewPortDTO::class,
        description: 'Location model'
    )]
    #[Groups(["swagger"])]
    public ?PlusCodeDTO $plusCode;

    #[SWG\Property(
        description: 'Geometry types',
        type: 'string'
    )]
    #[Groups(["swagger"])]
    public ?string $types = null;

    public function __construct(array $geoCodeData)
    {
        $this->addressComponents = array_map(
            fn (array $companyAddress) => new GoogleAddressComponentDTO($companyAddress),
            $geoCodeData['address_components'] ?? []
        );
        $this->geometry = ($geometry = $geoCodeData['geometry'] ?? null) ? new GoogleGeometryDTO($geometry) : null;
        $this->formattedAddress = $geoCodeData['formatted_address'] ?? null;
        $this->placeId = $geoCodeData['place_id'] ?? null;
        $this->plusCode = ($plusCode = $geoCodeData['plus_code'] ?? null) ? new PlusCodeDTO($plusCode) : null;
        $this->types = implode(', ', $geoCodeData['types']);
    }

    public function getType():?string
    {
        $addressComponents = $this->addressComponents;
        $firstAddressComponents = array_shift($addressComponents);

        return $firstAddressComponents->types;
    }

    public function getLat(): ?float
    {
        return $this->geometry->location->lat;
    }

    public function getLng(): ?float
    {
        return $this->geometry->location->lng;
    }

    public function getPostalCode(): ?string
    {
        $lastAddressComponents = array_pop($this->addressComponents);
        return $lastAddressComponents->types;
    }

    public function getAddressComponents(): array
    {
        return $this->addressComponents;
    }

    public function getGeometry(): ?GoogleGeometryDTO
    {
        return $this->geometry;
    }

    public function getFormattedAddress(): static
    {
        return $this->formattedAddress;
    }

    public function getPlaceId(): string
    {
        return $this->placeId;
    }

    public function getPlusCode(): ?PlusCodeDTO
    {
        return $this->plusCode;
    }

    public function getTypes(): ?string
    {
        return $this->types;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function isSuitableAddress(?AddressDTO $address = null): bool
    {
        $isZelenograd = mb_stripos(
                !empty(request()->get('address')) ? request()->get('address') : $address->address,
                'Зеленоград'
            ) !== false;

        $result = (
                $this->getType() === CompanyAddress::STREET_NUMBER->value ||
                $isZelenograd && $this->getType() == 'premise'
            ) && $this->getPostalCode();

        if (!$result){
            Log::info(
                "#geocoder #google isSuitableAddress is problem Current geocoder for address: $address, type: {$this->getType()}, postalCode: {$this->getPostalCode()}" . ucfirst(GeocoderType::getTypeByClass(get_class($this))->name)
            );
        }
        return $result;
    }

    public function jsonSerialize(): array
    {
        return
       [
           'addressComponents' => $this->addressComponents,
           'geometry' => $this->geometry,
           'formattedAddress' => $this->formattedAddress,
           'placeId' => $this->placeId,
           'plusCode' => $this->plusCode,
           'types' => $this->types,
       ];
    }

    public function getPoint(): ?Point
    {
        return $this->getLat() && $this->getLng() ? new Point($this->getLat(), $this->getLng()) : null;
    }
}
