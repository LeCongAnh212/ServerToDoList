<?php

namespace App\Repositories\Task;

use App\Enums\StatusDelete;
use App\Enums\TaskStatus;
use App\Interfaces\Task\TaskRepositoryInterface;
use App\Models\Task;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    /**
     * fetch all tasks with subtasks property
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getDataAllTaskWithSubtasks()
    {
        return $this->model->with('subtasks')
            ->join('type_tasks', 'tasks.type_id', 'type_tasks.id')
            ->select('tasks.*', 'type_tasks.name as type_name', 'type_tasks.id as type_id')
            ->where('tasks.is_delete', StatusDelete::NORMAL)
            ->orderByDESC('created_at')
            ->get();
    }

    /**
     * delete task by id
     * @param mixed $id
     * @return bool
     */
    public function deleteTask($id)
    {
        try {
            DB::beginTransaction();
            $this->model->where('id', $id)->update(['is_delete' => StatusDelete::DELETE]);
            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * get task by status
     * @param mixed $status
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTasksByStatus($status)
    {
        return $this->model->with('subtasks')
            ->join('type_tasks', 'tasks.type_id', 'type_tasks.id')
            ->select('tasks.*', 'type_tasks.name as type_name', 'type_tasks.id as type_id')
            ->where('tasks.is_delete', StatusDelete::NORMAL)
            ->where('tasks.status', $status)
            ->orderByDESC('created_at')
            ->get();
    }

    /**
     * find task by id contains subtasks and type
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findTaskById($id)
    {
        return $this->model->with('subtasks')
            ->join('type_tasks', 'tasks.type_id', 'type_tasks.id')
            ->select('tasks.*', 'type_tasks.name as type_name', 'type_tasks.id as type_id')
            ->find($id);
    }
}
