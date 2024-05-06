<?php

namespace App\Repositories\TypeTask;

use App\Enums\StatusDelete;
use App\Models\Task;
use App\Models\TypeTask;
use App\Repositories\BaseRepository;

class TypeTaskRepository extends BaseRepository
{
    public function __construct(TypeTask $task)
    {
        $this->model = $task;
    }

    /**
     * get list type task and tasks list of it
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTypeTaskWithListTask()
    {
        return $this->model->with([
            'tasks' => function ($query) {
                $query->with('typeTasks', 'subtasks')
                    ->where('tasks.is_delete', StatusDelete::NORMAL);
            }
        ])
            ->get();
    }

    /**
     * create type task
     * @param array $data
     * @return bool|TypeTask
     */
    public function createTypeTask($data)
    {
        $check = $this->model->where('name', $data['name'])->first();
        if($check){
            return false;
        }

        return $this->model->firstOrCreate(['name' => $data['name']], $data);
    }

    /**
     * find type task by id
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findTypeTaskById($id)
    {
        return $this->model->with([
            'tasks' => function ($query) {
                $query->with('typeTasks', 'subtasks')
                    ->where('tasks.is_delete', StatusDelete::NORMAL);
            }
        ])
            ->find($id);
    }
}
