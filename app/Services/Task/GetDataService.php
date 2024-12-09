<?php

namespace App\Services\Task;

use App\Interfaces\Task\TaskRepositoryInterface;
use App\Repositories\Task\TaskRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class GetDataService extends BaseService
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle()
    {
        try {
            return $this->taskRepository->getDataAllTaskWithSubtasks();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
