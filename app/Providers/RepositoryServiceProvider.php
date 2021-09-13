<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\TaskRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\TaskRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\ProjectRepositoryInterface;
use App\Repository\EloquentRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
