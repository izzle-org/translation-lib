<?php

use Izzle\Translation\Services\Translation;

if (!function_exists('trans')) {
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     * @throws Exception
     */
    function trans($key, $default = null)
    {
        return Translation::translate($key, $default);
    }
}

if (!function_exists('trans_load')) {
    function trans_load($json_file, $prefix = '')
    {
        Translation::load($json_file, $prefix);
    }
}
