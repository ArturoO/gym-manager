<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/events');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('List of all events', $crawler->filter('h3')->text());
    }
}
