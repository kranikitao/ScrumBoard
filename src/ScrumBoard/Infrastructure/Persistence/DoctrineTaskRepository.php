<?php

namespace ScrumBoard\Infrastructure\Persistence;

use Doctrine\ORM\EntityRepository;
use ScrumBoard\Domain\Model\Task;
use ScrumBoard\Domain\TaskRepository;

class DoctrineTaskRepository extends EntityRepository implements TaskRepository
{
    /**
     * @param Task $task
     */
    public function add(Task $task)
    {
        $this->getEntityManager()->persist($task);
    }

    public function commit()
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $id
     * @return null|Task
     */
    public function findById($id)
    {
        return $this->find($id);
    }
}
