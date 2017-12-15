<?php

namespace Izzle\Translation\Services;

use Noodlehaus\Config;

class Translation
{
    /**
     * @var Config
     */
    protected static $config;
    
    /**
     * @param string $key
     * @param mixed $detault
     * @throws \Exception
     */
    public static function translate($key, $default = null)
    {
        if (is_null(self::$config)) {
            throw new \Exception('No data is loaded. Please use the load method');
        }
        
        return self::$config->get($key, $default);
    }
    
    /**
     * @param string $json_file
     */
    public static function load($json_file)
    {
        if (!file_exists($json_file)) {
            throw new \InvalidArgumentException(sprintf('File (%s) does not exists', $json_file));
        }
        
        self::$config = new Config($json_file);
    }
}
