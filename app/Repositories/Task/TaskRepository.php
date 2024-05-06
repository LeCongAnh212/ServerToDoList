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
        return $this->model->with('subtasks', 'typeTasks')
            ->where('tasks.is_delete', StatusDelete::NORMAL)
            ->orderByDESC('created_at')
            ->get();
    }

    /**
     * delete task by id
     * @param int $id
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
     * @param int $status
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTasksByStatus($status)
    {
        return $this->model->with('subtasks', 'typeTasks')
            ->where('tasks.is_delete', StatusDelete::NORMAL)
            ->where('tasks.status', $status)
            ->orderByDESC('created_at')
            ->get();
    }

    /**
     * find task by id contains subtasks and type
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findTaskById($id)
    {
        return $this->model->with('subtasks', 'typeTasks')
            ->find($id);
    }

    /**
     * get task out date
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTaskOutDate()
    {
        return $this->model->with('subtasks', 'typeTasks')
            ->where('tasks.is_delete', StatusDelete::NORMAL)
            ->where('tasks.deadline', '<', now())
            ->get();
    }
}
