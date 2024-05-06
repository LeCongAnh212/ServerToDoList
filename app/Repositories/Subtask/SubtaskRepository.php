<?php

namespace App\Repositories\Subtask;

use App\Enums\StatusDelete;
use App\Models\Subtask;
use App\Repositories\BaseRepository;

class SubtaskRepository extends BaseRepository
{
    public function __construct(Subtask $task)
    {
        $this->model = $task;
    }

    public function deleteSubtask($id)
    {
        return $this->model->where('id', $id)->update(['is_delete' => StatusDelete::DELETE]);
    }

}
