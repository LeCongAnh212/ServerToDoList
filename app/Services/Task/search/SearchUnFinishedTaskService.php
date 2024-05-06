<?php

namespace App\Services\Task\search;

use App\Enums\TaskStatus;
use App\Interfaces\Task\SearchTaskRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class SearchUnFinishedTaskService extends BaseService
{
    protected $taskRepository;

    public function __construct(SearchTaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle()
    {
        try {
            return $this->taskRepository->searchTaskByStatus($this->data, TaskStatus::UNFINISHED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
