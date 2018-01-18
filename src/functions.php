<?php

use Izzle\Translation\ParameterEnclosure;
use Izzle\Translation\Services\Translation;

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
    function trans_load($json_file, ParameterEnclosure $enclosure, $prefix = '')
    {
        Translation::load($json_file, $enclosure, $prefix);
    }
}
