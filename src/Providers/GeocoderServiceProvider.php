<?php

namespace Geocoder\Providers;

use Geocoder\Geocoder\GeocoderInterface;
use Geocoder\Geocoder\GoogleGeocoder;
use Geocoder\Geocoder\YandexGeocoder;
use Geocoder\Polygon\Services\PolygonService;
use Geocoder\Polygon\Services\PolygonServiceInterface;
use Geocoder\Resolvers\GeocoderResolver;
use Geocoder\Resolvers\GeocoderResolverInterface;
use Illuminate\Support\ServiceProvider;

class GeocoderServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->Geocoder->bind(GeocoderResolverInterface::class, GeocoderResolver::class);
        $this->Geocoder->tag([GoogleGeocoder::class, YandexGeocoder::class], GeocoderInterface::class);
        $this->Geocoder->bind(PolygonServiceInterface::class, PolygonService::class);
    }
}