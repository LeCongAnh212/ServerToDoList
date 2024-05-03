<?php

namespace App\Services\Task;

use App\Repositories\Task\TaskRepository;
use App\Services\BaseService;

class GetTaskFinishedService extends BaseService
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle()
    {
        return $this->taskRepository->getTaskFinished();
    }
}

