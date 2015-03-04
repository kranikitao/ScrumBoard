<?php

namespace ScrumBoard\Infrastructure\Delivery\ScrumBoardBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function sendRequestToTask_ShouldReturn200OkAndNoTasks()
    {
        $client = static::createClient(['environment' => 'test']);

        $crawler = $client->request('GET', '/task/');

        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertTrue($crawler->filter('html>body>ul>li')->count() === 0);
    }

    /**
     * @test
     */
    public function sendRequestToTask_ShouldReturnActiveTasks()
    {

        $client = static::createClient(['environment' => 'test']);

        //todo: загрузить фикстуры
        $kernel = $client->getKernel();

        $crawler = $client->request('GET', '/task/');

        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertEquals(1, $crawler->filter('html>body>ul>li>a')->count());
    }
}
