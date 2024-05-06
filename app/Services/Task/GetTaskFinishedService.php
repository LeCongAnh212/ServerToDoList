<?php

namespace App\Services\Task;

use App\Enums\TaskStatus;
use App\Interfaces\Task\TaskRepositoryInterface;
use App\Repositories\Task\TaskRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class GetTaskFinishedService extends BaseService
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle()
    {
        try {
            return $this->taskRepository->getTasksByStatus(TaskStatus::FINISHED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
