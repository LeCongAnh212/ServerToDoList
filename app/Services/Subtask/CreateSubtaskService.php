<?php

namespace App\Services\Subtask;

use App\Repositories\Subtask\SubtaskRepository;
use App\Services\BaseService;

class CreateSubtaskService extends BaseService
{
    protected $subtaskRepository;

    public function __construct(SubtaskRepository $subtaskRepository)
    {
        $this->subtaskRepository = $subtaskRepository;
    }

    public function handle()
    {
        return $this->subtaskRepository->create($this->data);
    }
}
