<?php

namespace App\Interfaces\Task;

use App\Interfaces\CrudRepositoryInterface;

interface TaskRepositoryInterface extends CrudRepositoryInterface
{
    public function getDataAllTaskWithSubtasks();

    public function getTasksByStatus($status);

    public function deleteTask($id);

    public function findTaskById($id);
}
