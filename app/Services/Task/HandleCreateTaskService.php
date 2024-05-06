<?php

namespace App\Services\Task;

use App\Interfaces\Task\TaskRepositoryInterface;
use App\Repositories\Task\TaskRepository;
use App\Services\BaseService;
use App\Services\Subtask\CreateSubtaskService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HandleCreateTaskService extends BaseService
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle()
    {
        try {
            DB::beginTransaction();

            $data = $this->data;
            $data['user_id'] = auth()->user()->id;

            $task = resolve(CreateTaskService::class)->setParams($data)->handle();

            foreach ($data['subtasks'] as $subtaskData) {
                $subtaskData['task_id'] = $task->id;
                resolve(CreateSubtaskService::class)->setParams($subtaskData)->handle();
            }

            $task = resolve(FindTaskByIdService::class)->setParams($task->id)->handle();

            DB::commit();

            return $task;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());

            return false;
        }
    }
}
