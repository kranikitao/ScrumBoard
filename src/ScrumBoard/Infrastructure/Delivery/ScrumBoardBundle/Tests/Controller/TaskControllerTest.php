<?php

namespace ScrumBoard\Infrastructure\Delivery\ScrumBoardBundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = static::createClient(['environment' => 'test']);
        /** @var EntityManager $entityManager */
        $entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        $schema = new SchemaTool($entityManager);

        $schema->dropDatabase();
        $schema->createSchema($entityManager->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @test
     */
    public function get_requestToTask_ShouldReturn200OkAndNoTasks()
    {
        $crawler = $this->client->request('GET', '/task/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->filter('ul>li')->count());
    }

    /**
     * @test
     */
    public function post_createNewTask_ShouldReturn201Created()
    {
        $subject = 'Task subject';
        $description = 'Task description';
        $this->client->request('POST', '/task/', ['subject' => $subject, 'description' => $description]);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function post_createNewTask_createsTaskAndReturnsItsLocation()
    {
        $subject = 'Task subject';
        $description = 'Task description';
        $this->requestToCreateTask($subject, $description);

        $crawler = $this->client->request('GET', $this->client->getResponse()->headers->get('Location'));

        $itemNode = $crawler->filter('div');
        $this->assertEquals(1, $itemNode->count());
        $this->assertEquals($subject, $itemNode->attr('data-subject'));
        $this->assertEquals($description, $itemNode->attr('data-description'));
        $this->assertNotEmpty($itemNode->attr('data-id'));
    }

    /**
     * @test
     */
    public function get_createTasksAndRequestToTask_ReturnsTaskList()
    {
        $this->requestToCreateTask('task 1');
        $this->requestToCreateTask('task 2');
        $crawler = $this->client->request('GET', '/task/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(2, $crawler->filter('ul>li')->count());

    }

    /**
     * @test
     */
    public function post_createNewTask_createsTaskAndReturns()
    {
        $subject = 'Task subject';
        $description = 'Task description';
        $this->requestToCreateTask($subject, $description);

        $crawler = $this->client->request('GET', $this->client->getResponse()->headers->get('Location'));

        $itemNode = $crawler->filter('div');
        $this->assertEquals(1, $itemNode->count());
        $this->assertEquals($subject, $itemNode->attr('data-subject'));
        $this->assertEquals($description, $itemNode->attr('data-description'));
        $this->assertNotEmpty($itemNode->attr('data-id'));
    }

    /**
     * @param $subject
     * @param $description
     */
    private function requestToCreateTask($subject = 'Task subject', $description = 'Task description')
    {
        $this->client->request('POST', '/task/', ['subject' => $subject, 'description' => $description]);
    }
}
