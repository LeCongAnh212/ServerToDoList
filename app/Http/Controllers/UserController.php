<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use App\Services\User\CreateUserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    const EXPIRED_DAY_TOKEN = 7;

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

    /**
     * login account for user
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user && auth()->attempt(['email' => $request->email, 'password' => $request->password])){
            $token = auth()->user()->createToken(
                'authToken',
                ['*'],
                now()->addDays(self::EXPIRED_DAY_TOKEN)
            )->plainTextToken;

            return $this->responseSuccess([
                'message' => __('messages.user.login_success'),
                'token' => $token,
                'type_token' => 'Bearer',
            ]);
        }

        return $this->responseErrors(__('messages.incorrect_information'), Response::HTTP_UNAUTHORIZED);
    }
}
