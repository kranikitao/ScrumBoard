<?php

namespace ScrumBoard\Infrastructure\Delivery\ScrumBoardBundle\Tests\Controller;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public static function setUpBeforeClass()
    {
        $client = static::createClient(['environment' => 'test']);
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $schema = new SchemaTool($entityManager);

        $schema->dropDatabase();
        $schema->createSchema($entityManager->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @test
     */
    public function get_requestToTask_ShouldReturn200OkAndNoTasks()
    {
        $client = static::createClient(['environment' => 'test']);

        $crawler = $client->request('GET', '/task/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->filter('ul>li')->count());
    }

    /**
     * @test
     */
    public function post_createNewTask_ShouldReturn201Created()
    {
        $client = static::createClient(['environment' => 'test']);
        $subject = 'Task subject';
        $description = 'Task description';
        $client->request('POST', '/task/', ['subject' => $subject, 'description' => $description]);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function post_createNewTask_createsTaskAndReturnsItsLocation()
    {
        $client = static::createClient(['environment' => 'test']);
        $subject = 'Task subject';
        $description = 'Task description';
        $client->request('POST', '/task/', ['subject' => $subject, 'description' => $description]);

        $crawler = $client->request('GET', $client->getResponse()->headers->get('Location'));

        $itemNode = $crawler->filter('div');
        $this->assertEquals(1, $itemNode->count());
        $this->assertEquals($subject, $itemNode->attr('data-subject'));
        $this->assertEquals($description, $itemNode->attr('data-description'));
        $this->assertNotEmpty($itemNode->attr('data-id'));

    }
}
