<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Services\User\CreateUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    /**
     * register account for user
     * @param CreateUserRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function register(CreateUserRequest $request)
    {

        $user = resolve(CreateUserService::class)->setParams($request->all())->handle();

        if($user){
            return $this->responseSuccess([
                'message' => __('messages.user.signup_success')
            ], Response::HTTP_CREATED);
        }

        return $this->responseErrors(__('messages.user.incorrect_information'));
    }
}
