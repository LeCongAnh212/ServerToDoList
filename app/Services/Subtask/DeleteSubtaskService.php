<?php

namespace App\Services\Subtask;

use App\Interfaces\Subtask\SubTaskRepositoryInterface;
use App\Repositories\Subtask\SubtaskRepository;
use App\Services\BaseService;

class DeleteSubtaskService extends BaseService
{
    protected $subtaskRepository;

    public function __construct(SubTaskRepositoryInterface $subtaskRepository)
    {
        $this->subtaskRepository = $subtaskRepository;
    }

    public function handle()
    {
        return $this->subtaskRepository->deleteSubtask($this->data);
    }

}

