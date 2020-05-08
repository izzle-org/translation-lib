<?php

namespace Izzle\Translation\Services;

use Exception;
use InvalidArgumentException;
use Izzle\Translation\ParameterEnclosure;
use Noodlehaus\Config;
use Noodlehaus\Exception\EmptyDirectoryException;

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
     * @return mixed|string|string[]|null
     * @throws Exception
     */
    public static function translate($key, array $parameters = [])
    {
        if (self::$config === null) {
            throw new Exception('No data is loaded. Please use the load method');
        }
    
        $key = !empty(self::$prefix) ? sprintf('%s.%s', self::$prefix, $key) : $key;
        
        $translation = self::$config->get($key, $key);
        
        // Translation parameters
        foreach ($parameters as $parameter => $value) {
            $translation = str_replace(sprintf(self::$enclosure->getEnclosure(), $parameter), $value, $translation);
        }
        
        return $translation;
    }
    
    /**
     * @param string $jsonFile
     * @param ParameterEnclosure|null $enclosure
     * @param string $prefix
     * @throws InvalidArgumentException
     * @throws EmptyDirectoryException
     */
    public static function load($jsonFile, ParameterEnclosure $enclosure = null, $prefix = '')
    {
        if (!file_exists($jsonFile)) {
            throw new InvalidArgumentException(sprintf('File (%s) does not exists', $jsonFile));
        }
        
        if ($enclosure === null) {
            $enclosure = new ParameterEnclosure();
        }
        
        self::$config = new Config($jsonFile);
        self::$prefix = $prefix;
        self::$enclosure = $enclosure;
    }
    
    /**
     * @param ParameterEnclosure $enclosure
     */
    public static function setEnclosure(ParameterEnclosure $enclosure)
    {
        self::$enclosure = $enclosure;
    }
    
    /**
     * @param string $prefix
     */
    public static function setPrefix($prefix)
    {
        self::$prefix = $prefix;
    }
}
