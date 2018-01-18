<?php

namespace Izzle\Translation\Services;

use Izzle\Translation\ParameterEnclosure;
use Noodlehaus\Config;

class Translation
{
    /**
     * @var Config
     */
    protected static $config;
    
    /**
     * @var ParameterEnclosure
     */
    protected static $enclosure;
    
    /**
     * @var string
     */
    protected static $prefix = '';
    
    /**
     * @param string $key
     * @param array $parameters
     * @throws \Exception
     */
    public static function translate($key, array $parameters = [])
    {
        if (is_null(self::$config)) {
            throw new \Exception('No data is loaded. Please use the load method');
        }
    
        $key = !empty(self::$prefix) ? sprintf('%s.%s', self::$prefix, $key) : $key;
        
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
     * @param string $prefix
     * @throws \InvalidArgumentException
     */
    public static function load($json_file, ParameterEnclosure $enclosure, $prefix = '')
    {
        if (!file_exists($json_file)) {
            throw new \InvalidArgumentException(sprintf('File (%s) does not exists', $json_file));
        }
        
        self::$config = new Config($json_file);
        self::$prefix = $prefix;
        self::$enclosure = $enclosure;
    }
}
