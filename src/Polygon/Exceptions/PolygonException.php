<?php

namespace App\Polygon\Exceptions;

use RuntimeException;

class PolygonException extends RuntimeException
{
    protected $message = 'Polygon must have at least 3 points';
}
