<?php

namespace App\Services\Task\search;

use App\Enums\TaskStatus;
use App\Interfaces\Task\SearchTaskRepositoryInterface;
use App\Interfaces\Task\TaskRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class SearchFinishedTaskService extends BaseService
{
    protected $taskRepository;

    public function __construct(SearchTaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle()
    {
        try {
            return $this->taskRepository->searchTaskByStatus($this->data, TaskStatus::FINISHED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
