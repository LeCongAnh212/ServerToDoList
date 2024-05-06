<?php

namespace App\Interfaces\Subtask;

use App\Interfaces\CrudRepositoryInterface;

interface SubTaskRepositoryInterface extends CrudRepositoryInterface
{
    public function deleteSubtask($id);
}
