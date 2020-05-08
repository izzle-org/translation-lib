<?php

use Izzle\Translation\ParameterEnclosure;
use Izzle\Translation\Services\Translation;
use Noodlehaus\Exception\EmptyDirectoryException;

if (!function_exists('trans')) {
    /**
     * @param string $key
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    function trans($key, array $parameters = [])
    {
        return Translation::translate($key, $parameters);
    }
}

if (!function_exists('trans_load')) {
    /**
     * @param $jsonFile
     * @param ParameterEnclosure|null $enclosure
     * @param string $prefix
     * @throws EmptyDirectoryException
     */
    function trans_load($jsonFile, ParameterEnclosure $enclosure = null, $prefix = '')
    {
        Translation::load($jsonFile, $enclosure, $prefix);
    }
}
