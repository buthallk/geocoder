<?php

namespace Geocoder\Providers;

use Geocoder\Factories\GeoCodeAddressFactory;
use Geocoder\Factories\GeoCodeAddressFactoryInterface;
use Geocoder\Geocoder\GeocoderInterface;
use Geocoder\Geocoder\GoogleGeocoder;
use Geocoder\Geocoder\YandexGeocoder;
use Geocoder\Polygon\Services\PolygonService;
use Geocoder\Polygon\Services\PolygonServiceInterface;
use Geocoder\Resolvers\GeocoderResolver;
use Geocoder\Resolvers\GeocoderResolverInterface;
use Geocoder\Services\CityService;
use Geocoder\Services\CityServiceInterface;
use Geocoder\Services\GeocoderService;
use Geocoder\Services\GeocoderServiceInterface;
use Illuminate\Support\ServiceProvider;

class GeocoderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/geocoder.config.php' => config_path('geocoder.config.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind(GeocoderResolverInterface::class, GeocoderResolver::class);
        $this->app->tag([GoogleGeocoder::class, YandexGeocoder::class], GeocoderInterface::class);
        $this->app->bind(PolygonServiceInterface::class, PolygonService::class);
        $this->app->bind(GeoCodeAddressFactoryInterface::class, GeoCodeAddressFactory::class);
        $this->app->bind(GeocoderServiceInterface::class, GeocoderService::class);
        $this->app->bind(CityServiceInterface::class, CityService::class);
    }
}