<?php

namespace ScrumBoard\Infrastructure\Delivery\ScrumBoardBundle\Controller;

use ScrumBoard\Domain\Model\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $tasks = $this->getTaskRepository()->findAll();

        return new Response($this->renderView('ScrumBoardBundle:Task:index.html.twig', compact('tasks')), 200);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function getAction($id)
    {
        $task = $this->getTaskRepository()->findById($id);

        return new Response($this->renderView('ScrumBoardBundle:Task:get.html.twig', ['task' => $task]), 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $task = new Task(
            $request->request->get('subject'),
            $request->request->get('description')
        );

        $taskRepository = $this->get('task_repository');

        $taskRepository->add($task);
        $taskRepository->commit();

        $location = sprintf('/task/%u', $task->getId());

        return new Response('', 201, ['Location' => $location]);
    }

    /**
     * @return \ScrumBoard\Domain\TaskRepository
     */
    private function getTaskRepository()
    {
        return $this->get('task_repository');
    }
}
