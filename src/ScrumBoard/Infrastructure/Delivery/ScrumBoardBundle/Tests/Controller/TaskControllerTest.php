<?php

namespace ScrumBoard\Infrastructure\Delivery\ScrumBoardBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function get_requestToTask_ShouldReturn200OkAndNoTasks()
    {
        $client = static::createClient(['environment' => 'test']);

        $crawler = $client->request('GET', '/task/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->filter('html>body>ul>li')->count());
    }

    /**
     * @test
     */
    public function post_createNewTask_ShouldReturn201Created()
    {

        $client = static::createClient(['environment' => 'test']);
        $client->request('POST', '/task/');

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}
