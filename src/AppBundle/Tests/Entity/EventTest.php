<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testDescriptionLength()
    {
        $Event = new Event();
        $Event->setDescription('Lorem ipsum sid altum videtur');

        
        $this->assertEquals(29, $Event->getDescriptionLength());
    }
}