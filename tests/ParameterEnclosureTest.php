<?php

namespace Izzle\Translation\Test;

use InvalidArgumentException;
use Izzle\Translation\ParameterEnclosure;
use PHPUnit\Framework\TestCase;

class ParameterEnclosureTest extends TestCase
{
    public function testCanCreateAnInstance()
    {
        $enclosure = new ParameterEnclosure();
        
        $this->assertEquals(ParameterEnclosure::ENCLOSURE_BRACER, $enclosure->getEnclosure());
        
        $this->expectException(InvalidArgumentException::class);
        new ParameterEnclosure('foo');
    }
    
    /**
     * @depends testCanCreateAnInstance
     */
    public function testCanSetEnclosure()
    {
        $enclosure = new ParameterEnclosure();
        $enclosure->setEnclosure(ParameterEnclosure::ENCLOSURE_COLON);
    
        $this->assertEquals(ParameterEnclosure::ENCLOSURE_COLON, $enclosure->getEnclosure());
    }
}
