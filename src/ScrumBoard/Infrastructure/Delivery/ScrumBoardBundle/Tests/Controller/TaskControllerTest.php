<?php

namespace ScrumBoard\Infrastructure\Delivery\ScrumBoardBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function test_SendRequestToTask_ShouldReturn200OkAndNoTasks()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/task/', []);

        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertTrue($crawler->filter('html>body>ul>li')->count() === 0);
    }
}
