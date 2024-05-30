<?php

namespace UmamZ\UkppLubangsa\Helper;

use ReflectionClass;
use ReflectionProperty;
use UmamZ\UkppLubangsa\Exception\ValidationException;

class ValidationUtil
{
    static function validate($request)
    {
        $reflection = new ReflectionClass($request);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            if (is_null($property->getValue($request)) || trim($property->getValue($request)) == '' || $property->getValue($request) == 0) {
               throw new ValidationException("$property->name tidak boleh kosong");
            }
        }
    }
}