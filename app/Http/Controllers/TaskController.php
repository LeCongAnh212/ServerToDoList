<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Models\Task;
use App\Services\Subtask\CreateSubtaskService;
use App\Services\Subtask\DeleteSubtaskService;
use App\Services\Task\CreateTaskService;
use App\Services\Task\DeleteTaskService;
use App\Services\Task\FindTaskByIdService;
use App\Services\Task\GetDataService;
use App\Services\Task\GetTaskFinishedService;
use App\Services\Task\GetTaskOutDateService;
use App\Services\Task\GetTaskUnFinishedService;
use App\Services\Task\HandleCreateTaskService;
use App\Services\Task\HandleUpdateTaskService;
use App\Services\Task\search\SearchAllTaskService;
use App\Services\Task\search\SearchFinishedTaskService;
use App\Services\Task\search\SearchOutDateTaskService;
use App\Services\Task\search\SearchUnFinishedTaskService;
use App\Services\Task\UpdateTaskService;
use App\Services\TypeTask\GetTypeTaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{

    /**
     * get data task and subtasks
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateTaskRequest $request)
    {
        $task = resolve(HandleCreateTaskService::class)->setParams($request->all())->handle();

        if ($task) {
            return $this->responseSuccess([
                'task' => $task
            ]);
        }

        return $this->responseErrors(__('messages.error_server'));
    }

    /**
     * delete task
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
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

    /**
     * update task and subtasks
     * @param \App\Http\Requests\Task\CreateTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateTaskRequest $request)
    {
        $task = resolve(HandleUpdateTaskService::class)->setParams($request->all())->handle();

        if ($task) {
            return $this->responseSuccess([
                'task' => $task,
                'message' => __('messages.update_success')
            ]);
        }

        return $this->responseErrors(__('messages.error_server'));
    }

    /**
     * get task finished
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataFinished()
    {
        $tasks = resolve(GetTaskFinishedService::class)->handle();

        if ($tasks) {
            return $this->responseSuccess([
                'tasks' =>  $tasks
            ]);
        }

        return $this->responseErrors(__('messages.error_server'));
    }

    /**
     * get task unfinished
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataUnFinished()
    {
        $tasks = resolve(GetTaskUnFinishedService::class)->handle();

        if ($tasks) {
            return $this->responseSuccess([
                'tasks' =>  $tasks
            ]);
        }

        return $this->responseErrors(__('messages.error_server'));
    }

    /**
     * get tasks out date
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataOutDate()
    {
        $tasks = resolve(GetTaskOutDateService::class)->handle();

        if ($tasks) {
            return $this->responseSuccess([
                'tasks' => $tasks
            ]);
        }

        return $this->responseErrors(__('messages.error_server'));
    }

    public function search(Request $request)
    {
        $allTasks = resolve(SearchAllTaskService::class)->setParams($request->keyword)->handle();
        $finishedTasks = resolve(SearchFinishedTaskService::class)->setParams($request->keyword)->handle();
        $unfinishedTasks = resolve(SearchUnFinishedTaskService::class)->setParams($request->keyword)->handle();
        $outDateTasks = resolve(SearchOutDateTaskService::class)->setParams($request->keyword)->handle();


        return $this->responseSuccess([
            'allTasks' => $allTasks,
            'finishedTasks' => $finishedTasks,
            'unfinishedTasks' => $unfinishedTasks,
            'outDateTasks' => $outDateTasks,
        ]);
    }
}
