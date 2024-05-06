<?php

namespace App\Services\Task\search;

use App\Enums\TaskStatus;
use App\Interfaces\Task\SearchTaskRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class SearchOutDateTaskService extends BaseService
{
    protected $taskRepository;

    public function __construct(SearchTaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle()
    {
        try {
            return $this->taskRepository->searchOutDateTask($this->data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
