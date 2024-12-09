<?php

namespace App\Services\TypeTask;

use App\Interfaces\TypeTask\TypeTaskRepositoryInterface;
use App\Repositories\Task\TaskRepository;
use App\Repositories\TypeTask\TypeTaskRepository;
use App\Services\BaseService;


class GetTypeTaskService extends BaseService
{
    protected $typeTaskRepository;

    public function __construct(TypeTaskRepository $typeTaskRepository)
    {
        $this->typeTaskRepository = $typeTaskRepository;
    }

    public function handle()
    {
        return $this->typeTaskRepository->all();
    }
}
