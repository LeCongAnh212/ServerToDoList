<?php

namespace App\Services\Task;

use App\Interfaces\Task\TaskRepositoryInterface;
use App\Repositories\Task\TaskRepository;
use App\Services\BaseService;
use App\Services\Subtask\CreateSubtaskService;
use App\Services\Subtask\DeleteSubtaskService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HandleUpdateTaskService extends BaseService
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

            $task = resolve(UpdateTaskService::class)->setParams($this->data)->handle();

            if ($task) {
                $task = resolve(FindTaskByIdService::class)->setParams($task->id)->handle();
                Log::info($task);
                foreach ($this->data['idDeleteSubtask'] as $key => $value) {
                    resolve(DeleteSubtaskService::class)->setParams($value)->handle();
                }

                foreach ($this->data['subtasks'] as $subtask) {
                    if (empty($subtask['id'])) {
                        $subtask['task_id'] = $this->data['id'];
                        resolve(CreateSubtaskService::class)->setParams($subtask)->handle();
                    }
                }
                DB::commit();

                return $task;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());

            return false;
        }
    }
}
