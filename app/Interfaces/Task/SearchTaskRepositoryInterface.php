<?php

namespace App\Interfaces\Task;

use App\Interfaces\CrudRepositoryInterface;

interface SearchTaskRepositoryInterface extends CrudRepositoryInterface
{
    public function searchAllTask($keyword);

    public function searchTaskByStatus($keyword, $taskStatus);

    public function searchOutDateTask($keyword);

}
