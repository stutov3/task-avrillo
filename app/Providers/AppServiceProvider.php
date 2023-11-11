<?php

namespace App\Providers;

use App\Contracts\ProjectServiceInterface;
use App\Contracts\ProjectStatisticsServiceInterface;
use App\Contracts\TaskServiceInterface;
use App\Services\DeadlineCheckerService;
use App\Services\ProjectService;
use App\Services\ProjectStatisticsService;
use App\Services\TaskService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProjectServiceInterface::class, ProjectService::class);
        $this->app->bind(ProjectStatisticsServiceInterface::class, ProjectStatisticsService::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
        $this->app->singleton(DeadlineCheckerService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
