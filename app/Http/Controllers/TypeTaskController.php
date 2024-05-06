<?php

namespace App\Http\Controllers;

use App\Services\TypeTask\CreateTypeTaskService;
use App\Services\TypeTask\FindTypeTaskByIdService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeTaskController extends Controller
{
    /**
     * create type task
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTypeTask(Request $request)
    {
        $type = resolve(CreateTypeTaskService::class)->setParams($request->name)->handle();

        if ($type) {
            $type = resolve(FindTypeTaskByIdService::class)->setParams($type->id)->handle();

            return $this->responseSuccess([
                'type' => $type
            ], Response::HTTP_CREATED);
        }

        return $this->responseErrors(__('messages.type_task_exists'));
    }
}
