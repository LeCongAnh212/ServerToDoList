<?php

namespace App\Repositories\TypeTask;

use App\Models\Task;
use App\Models\TypeTask;
use App\Repositories\BaseRepository;

class TypeTaskRepository extends BaseRepository
{
    public function __construct(TypeTask $task)
    {
        $this->model = $task;
    }

}
