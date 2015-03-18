<?php

namespace ScrumBoard\Infrastructure\Delivery\ScrumBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * @return Response
     */
    public function getAction()
    {
        return new Response();
    }

    /**
     * @return Response
     */
    public function createAction()
    {
        return new Response('', 201);
    }
}
