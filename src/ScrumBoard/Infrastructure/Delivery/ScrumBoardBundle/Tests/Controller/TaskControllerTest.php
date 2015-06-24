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
    public function getTask_NoTasks_Returns200OkAndEmptyItemList()
    {
        $crawler = $this->client->request('GET', '/task/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->filter('ul>li')->count());
    }

    /**
     * @test
     */
    public function getTask_GivenTwoTasks_ReturnsTwoItems()
    {
        $this->givenTaskAndReturnLocation('task 1');
        $this->givenTaskAndReturnLocation('task 2');
        $crawler = $this->client->request('GET', '/task/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(2, $crawler->filter('ul>li')->count());
    }

    /**
     * @test
     */
    public function getTask_GivenTask_ReturnsTaskWithCorrectValues()
    {
        $subject = 'Task subject';
        $description = 'Task description';
        $location = $this->givenTaskAndReturnLocation($subject, $description);

        $crawler = $this->client->request('GET', $location);

        $itemNode = $crawler->filter('div');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $itemNode->count());
        $this->assertEquals($subject, $itemNode->attr('data-subject'));
        $this->assertEquals($description, $itemNode->attr('data-description'));
        $this->assertNotEmpty($itemNode->attr('data-id'));
    }

    /**
     * @test
     */
    public function postTask_GivenValidRequest_Returns201()
    {
        $subject = 'Task subject';
        $description = 'Task description';
        $this->client->request('POST', '/task/', ['subject' => $subject, 'description' => $description]);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postTask_GivenValidRequest_ResponseWithLocation()
    {
        $subject = 'Task subject';
        $description = 'Task description';
        $this->client->request('POST', '/task/', ['subject' => $subject, 'description' => $description]);

        $this->assertEquals('/task/1', $this->client->getResponse()->headers->get('Location'));
    }
//
//    public function putTask_GivenValidRequest_...

    /**
     * @param string $subject
     * @param string $description
     * @return array|string
     */
    private function givenTaskAndReturnLocation($subject = 'Task subject', $description = 'Task description')
    {
        $this->client->request('POST', '/task/', ['subject' => $subject, 'description' => $description]);

        return $this->client->getResponse()->headers->get('Location');
    }
}
