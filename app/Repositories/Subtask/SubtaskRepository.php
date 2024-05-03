<?php

namespace App\Repositories\Subtask;

use App\Models\Subtask;
use App\Repositories\BaseRepository;

class SubtaskRepository extends BaseRepository
{
    public function __construct(Subtask $task)
    {
        $this->model = $task;
    }

}
