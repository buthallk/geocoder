<?php

namespace Geocoder\Enums;

enum CompanyAddress: string
{
    case COMPANY_ADDRESS_CACHE_KEY = '_cacheг';
    case FIELD_KEY_ADDRESS = 'address';
    case FIELD_KEY_HOME_NUMBER = 'homeNumber';
    case FIELD_KEY_BUILDING = 'building';
    case FIELD_KEY_INTERCOM = 'intercom';
    case FIELD_KEY_FLOOR = 'floor ';
    case FIELD_KEY_APARTMENT = 'apartment';
    case FIELD_KEY_COMMENT = 'comment';
    case CACHE_KEY = 'cacheKey';
    case FIELD_KEY_CITY = 'city';
    case STREET_NUMBER = 'street_number';
    case HOUSE = 'house';

    public const FIELDS = [
        'key',
        'value',
        'expiration',
    ];
}
