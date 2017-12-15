<?php

namespace Izzle\Translation\Services;

use Noodlehaus\Config;

class Translation
{
    /**
     * @var bool
     */
    protected static $isBooted = false;
    
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
        if (!self::$isBooted) {
            self::boot();
        }
        
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
        
        /*
        if (($json = file_get_contents($json_file)) === false) {
            throw new \InvalidArgumentException(sprintf('Error while reading file (%s)', $json_file));
        }
        
        $data = json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException(sprintf('JSON parsing error occured (%s)', json_last_error_msg()));
        }
        
        if (!($data instanceof \stdClass)) {
            throw new \InvalidArgumentException('Root JSON data must be an object');
        }
        */
        
        self::$config = new Config($json_file);
    }
    
    protected static function boot()
    {
        self::$isBooted = (require_once (__DIR__ . '/../bootstrap.php'));
    }
}
