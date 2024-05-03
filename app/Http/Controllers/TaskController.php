<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Models\Task;
use App\Services\Subtask\CreateSubtaskService;
use App\Services\Task\CreateTaskService;
use App\Services\Task\DeleteTaskService;
use App\Services\Task\GetDataService;
use App\Services\TypeTask\GetTypeTaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{

    /**
     * get data task and subtasks
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getData(Request $request)
    {
        $tasks = resolve(GetDataService::class)->handle();

        if ($tasks) {
            return $this->responseSuccess([
                'tasks' => $tasks
            ]);
        }

        return $this->responseErrors(__('messages.error_server'));
    }

    /**
     * get all type task
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getTypeTask()
    {
        $types = resolve(GetTypeTaskService::class)->handle();

        if ($types) {
            return $this->responseSuccess([
                'types' => $types
            ]);
        }

        return $this->responseErrors(__('messages.error_server'));
    }

    /**
     * create task and subtasks
     * @param \App\Http\Requests\Task\CreateTaskRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function create(CreateTaskRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['user_id'] = auth()->user()->id;

            $task = resolve(CreateTaskService::class)->setParams($data)->handle();

            $subtasks = [];
            foreach ($request->subtasks as $subtaskData) {
                $subtaskData['task_id'] = $task->id;
                $subtask = resolve(CreateSubtaskService::class)->setParams($subtaskData)->handle();
                $subtasks[] = $subtask;
            }
            $task['subtasks'] = $subtasks;

            DB::commit();

            return $this->responseSuccess([
                'task' => $task,
                'message' => __('messages.create_success')
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->responseErrors($th->getMessage());
            // return $this->responseErrors(__('messages.error_server'));
        }
    }

    /**
     * delete task
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function detele(Request $request)
    {
        $task = resolve(DeleteTaskService::class)->setParams($request->id)->handle();

        if ($task) {
            return $this->responseSuccess([
                'message' => __('messages.delete_success')
            ]);
        }

        return $this->responseErrors(__('messages.error_server'));
    }
}
