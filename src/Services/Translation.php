<?php

namespace Izzle\Translation\Services;

use Exception;
use InvalidArgumentException;
use Noodlehaus\Config;
use Noodlehaus\Exception\EmptyDirectoryException;

/**
 * Class Translation
 * @package Izzle\Translation\Services
 */
class Translation
{
    /**
     * @var Config
     */
    protected static $config;
    
    /**
     * @param string $key
     * @return mixed|null
     * @throws Exception
     */
    public static function translate($key)
    {
        if (self::$config === null) {
            throw new Exception('No data is loaded. Please use the load method first');
        }
        
        return self::$config->get($key, $key);
    }
    
    /**
     * @param string $jsonFile
     * @param string $node
     * @throws EmptyDirectoryException
     */
    public static function load($jsonFile, $node = null)
    {
        if (!file_exists($jsonFile)) {
            throw new InvalidArgumentException(sprintf('File (%s) does not exists', $jsonFile));
        }

        self::$config = new Config($jsonFile);
    }
}
