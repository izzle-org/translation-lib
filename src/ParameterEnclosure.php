<?php

namespace Izzle\Translation;

use InvalidArgumentException;

/**
 * Class ParameterEnclosure
 * @package Izzle\Translation
 */
class ParameterEnclosure
{
    const ENCLOSURE_BRACER = '{%s}';
    const ENCLOSURE_COLON = ':%s';
    
    /**
     * @var string
     */
    protected $enclosure = '';
    
    /**
     * @return string
     */
    public function getEnclosure()
    {
        return $this->enclosure;
    }
    
    /**
     * @param string $enclosure
     * @throws InvalidArgumentException
     * @return ParameterEnclosure
     */
    public function setEnclosure($enclosure)
    {
        switch ($enclosure) {
            case self::ENCLOSURE_BRACER:
            case self::ENCLOSURE_COLON:
                $this->enclosure = $enclosure;
                break;
            default:
                throw new InvalidArgumentException(sprintf('Enclosure type %s not supported', $enclosure));
        }
        
        return $this;
    }
}
