<?php

namespace App\Repositories\Task;

use App\Enums\StatusDelete;
use App\Enums\TaskStatus;
use App\Interfaces\Task\SearchTaskRepositoryInterface;
use App\Models\Task;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class SearchTaskRepository extends BaseRepository implements SearchTaskRepositoryInterface
{
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    /**
     * base data is used to load additional data
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function baseData()
    {
        return $this->model->with('subtasks', 'typeTasks')
            ->where('tasks.is_delete', StatusDelete::NORMAL)
            ->orderByDESC('created_at');
    }
    /**
     * search all task by keyword
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function searchAllTask($keyword)
    {
        $keyword = '%' . $keyword . '%';

        return $this->baseData()
            ->where('tasks.title', 'like', $keyword)
            ->get();
    }

    /**
     * search task finished by keyword
     * @param string $keyword
     * @param int $taskStatus
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function searchTaskByStatus($keyword, $taskStatus)
    {
        return $this->baseData()
            ->where('tasks.title', 'like', '%' . $keyword . '%')
            ->where('tasks.status', $taskStatus)
            ->get();
    }

    public function searchOutDateTask($keyword)
    {
        return $this->baseData()
            ->where('tasks.title', 'like', '%' . $keyword . '%')
            ->where('tasks.deadline', '<', now())
            ->get();
    }
}
