<?php

namespace App\Services\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Mail\NotificationMail;
use App\Repositories\User\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class SendMailToUser extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        try {
            // Log::info($this->data['email']);
            Mail::to($this->data['email'])->send(new NotificationMail($this->data));

            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
