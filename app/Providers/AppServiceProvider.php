<?php

namespace App\Providers;

use App\Interfaces\Subtask\SubTaskRepositoryInterface;
use App\Interfaces\Task\TaskRepositoryInterface;
use App\Interfaces\TypeTask\TypeTaskRepositoryInterface;
use App\Interfaces\User\UserRepositoryInterface;
use App\Models\Task;
use App\Observers\TaskObserver;
se App\Repositories\Subtask\SubtaskRepository;
use App\Repositories\Task\TaskRepository;
use App\Repositories\TypeTask\TypeTaskRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TypeTaskRepositoryInterface::class, TypeTaskRepository::class);
        $this->app->bind(SubTaskRepositoryInterface::class, SubtaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Task::observe(TaskObserver::class);
    }
}
