<?php

namespace App\Modules\GeoCode\Resolvers;

use App\Modules\GeoCode\Geocoder\GeocoderInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class GeocoderResolver implements GeocoderResolverInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getGeocoderByType(string $geoCoderType): GeocoderInterface
    {
        foreach ($this->container->tagged(GeocoderInterface::class) as $geoCoder)
        {
            if($geoCoder->canHandle($geoCoderType))
            {
                return $geoCoder;
            }
        }

        throw new \RuntimeException(sprintf('No handler for import %s', $geoCoderType));
    }
}
