<?php

namespace App\Repositories\User;

use App\Enums\StatusDelete;
use App\Interfaces\User\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getTaskOutOfDate()
    {
        return $this->model->join('tasks', 'users.id', 'tasks.user_id')
            ->where('tasks.deadline', '<', now())
            ->where('tasks.is_delete', StatusDelete::NORMAL)
            ->orderBy('tasks.deadline')
            ->select('users.email', 'tasks.*')
            ->get();
    }
}
