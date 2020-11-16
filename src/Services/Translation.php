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
    protected $config;
    
    /**
     * @var ParameterEnclosure
     */
    protected $enclosure;
    
    /**
     * @var string
     */
    protected $prefix = '';
    
    /**
     * Translation constructor.
     * @param string $jsonFile
     * @param ParameterEnclosure|null $enclosure
     * @param string $prefix
     * @throws EmptyDirectoryException
     */
    public function __construct(string $jsonFile, ParameterEnclosure $enclosure = null, string $prefix = '')
    {
        $this->load($jsonFile, $enclosure, $prefix);
    }
    
    /**
     * @param string $key
     * @param array $parameters
     * @return mixed|string|string[]|null
     * @throws Exception
     */
    public function translate(string $key, array $parameters = [])
    {
        if ($this->config === null) {
            throw new Exception('No data is loaded. Please use the load method');
        }
    
        $key = !empty($this->prefix) ? sprintf('%s.%s', $this->prefix, $key) : $key;
        
        $translation = $this->config->get($key, $key);
        
        // Translation parameters
        foreach ($parameters as $parameter => $value) {
            $translation = str_replace(sprintf($this->enclosure->getEnclosure(), $parameter), $value, $translation);
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
    public function load(string $jsonFile, ParameterEnclosure $enclosure = null, string $prefix = ''): void
    {
        if (!file_exists($jsonFile)) {
            throw new InvalidArgumentException(sprintf('File (%s) does not exists', $jsonFile));
        }
        
        if ($enclosure === null) {
            $enclosure = new ParameterEnclosure();
        }
        
        $this->config = new Config($jsonFile);
        $this->prefix = $prefix;
        $this->enclosure = $enclosure;
    }
    
    /**
     * @param ParameterEnclosure $enclosure
     * @return self
     */
    public function setEnclosure(ParameterEnclosure $enclosure): self
    {
        $this->enclosure = $enclosure;
        return $this;
    }
    
    /**
     * @param string $prefix
     * @return self
     */
    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;
        return $this;
    }
}
