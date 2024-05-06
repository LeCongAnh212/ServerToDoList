<?php

namespace App\Services\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Log;

class HandleSendMail extends SendMailToUser
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        try {
            $taskOutOfDate = $this->userRepository->getTaskOutOfDate();
            foreach ($taskOutOfDate as $key => $value) {
                resolve(SendMailToUser::class)->setParams($value)->handle();
            }

            return $taskOutOfDate;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
