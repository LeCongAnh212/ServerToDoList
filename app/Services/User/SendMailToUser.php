<?php

namespace App\Services\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Mail\TestMail;
use App\Repositories\User\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class SendMailToUser extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        try {
            // Log::info($this->data['email']);
            Mail::to($this->data['email'])->send(new TestMail($this->data));

            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
