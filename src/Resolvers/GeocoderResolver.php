<?php

namespace App\Resolvers;

use App\Geocoder\GeocoderInterface;
use Psr\Container\ContainerInterface;

class GeocoderResolver implements GeocoderResolverInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

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
