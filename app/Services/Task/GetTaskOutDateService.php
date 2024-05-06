<?php

namespace App\Services\Task;

use App\Interfaces\Task\TaskRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class GetTaskOutDateService extends BaseService
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle()
    {
        try {
            return $this->taskRepository->getTaskOutDate();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
