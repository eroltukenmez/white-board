<?php

namespace App\Providers;

use App\Repositories\Applications\ApplicationAssignmentRepository;
use App\Repositories\Applications\ApplicationAssignmentRepositoryInterface;
use App\Repositories\Applications\ApplicationRepository;
use App\Repositories\Applications\ApplicationRepositoryInterface;
use App\Repositories\Applications\ApplicationResponseRepository;
use App\Repositories\Applications\ApplicationResponseRepositoryInterface;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Department\DepartmentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);

        $this->app->bind(ApplicationRepositoryInterface::class, ApplicationRepository::class);
        $this->app->bind(ApplicationAssignmentRepositoryInterface::class, ApplicationAssignmentRepository::class);
        $this->app->bind(ApplicationResponseRepositoryInterface::class, ApplicationResponseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $view->with('csp_nonce', request()->attributes->get('csp_nonce'));
        });
    }
}
