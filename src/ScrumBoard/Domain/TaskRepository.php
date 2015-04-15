<?php

namespace ScrumBoard\Domain;

use ScrumBoard\Domain\Model\Task;

interface TaskRepository
{
    /**
     * @param Task $task
     */
    public function add(Task $task);

    public function commit();

    /**
     * @param string $id
     * @return Task|null
     */
    public function findById($id);

    /**
     * @return Task[]
     */
    public function findAll();
}
