<?php

namespace ScrumBoard\Infrastructure\Delivery\ScrumBoardBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function test_SendRequestToTask_ShouldReturnActiveTasks()
    {
        $client = static::createClient();
        $this->fail('ololo');
    }
}
