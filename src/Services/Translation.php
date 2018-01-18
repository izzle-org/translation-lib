<?php

namespace Izzle\Translation\Services;

use Izzle\Translation\ParameterEnclosure;
use Noodlehaus\Config;

class Translation
{
    /**
     * @var bool
     */
    protected static $isBooted = false;
    
    /**
     * @var ParameterEnclosure
     */
    protected static $enclosure;
    
    /**
     * @var Config
     */
    protected static $config;
    
    /**
     * @param string $key
     * @param array $parameters
     * @throws \Exception
     */
    public static function translate($key, array $parameters = [])
    {
        if (!self::$isBooted) {
            self::boot();
        }
        
        if (is_null(self::$config)) {
            throw new \Exception('No data is loaded. Please use the load method');
        }
        
        $value = self::$config->get($key, $key);
        
        // Translation parameters
        foreach ($parameters as $parameter) {
            if (!is_array($parameter)) {
                continue;
            }
            
            foreach ($parameter as $k => $v) {
                $value = str_replace(sprintf(self::$enclosure->getEnclosure(), $k), $v, $value);
            }
        }
        
        return $value;
    }
    
    /**
     * @param string $json_file
     * @param ParameterEnclosure $enclosure
     */
    public static function load($json_file, ParameterEnclosure $enclosure)
    {
        if (!file_exists($json_file)) {
            throw new \InvalidArgumentException(sprintf('File (%s) does not exists', $json_file));
        }
        
        self::$config = new Config($json_file);
        self::$enclosure = $enclosure;
    }
    
    protected static function boot()
    {
        self::$isBooted = (require_once (__DIR__ . '/../bootstrap.php'));
    }
}
