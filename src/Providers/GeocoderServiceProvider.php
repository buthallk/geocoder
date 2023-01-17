<?php

namespace App\Providers;

use App\Geocoder\GeocoderInterface;
use App\Geocoder\GoogleGeocoder;
use App\Geocoder\YandexGeocoder;
use App\Polygon\Services\PolygonService;
use App\Polygon\Services\PolygonServiceInterface;
use App\Resolvers\GeocoderResolver;
use App\Resolvers\GeocoderResolverInterface;
use Illuminate\Support\ServiceProvider;

class GeocoderServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->bind(GeocoderResolverInterface::class, GeocoderResolver::class);
        $this->app->tag([GoogleGeocoder::class, YandexGeocoder::class], GeocoderInterface::class);
        $this->app->bind(PolygonServiceInterface::class, PolygonService::class);
    }
}