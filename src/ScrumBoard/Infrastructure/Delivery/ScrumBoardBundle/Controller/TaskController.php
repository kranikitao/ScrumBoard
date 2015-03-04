<?php

namespace ScrumBoard\Infrastructure\Delivery\ScrumBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function indexAction()
    {
        return new Response();
    }
}
