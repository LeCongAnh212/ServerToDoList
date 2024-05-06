<?php

namespace App\Services\TypeTask;

use App\Repositories\TypeTask\TypeTaskRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class FindTypeTaskByIdService extends BaseService
{
    protected $typeTaskRepository;

    public function __construct(TypeTaskRepository $typeTaskRepository)
    {
        $this->typeTaskRepository = $typeTaskRepository;
    }

    public function handle()
    {
        try {
            return $this->typeTaskRepository->findTypeTaskById($this->data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
