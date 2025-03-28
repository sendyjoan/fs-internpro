<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\ClassRepository;
use App\Repositories\Eloquent\MajorRepository;
use App\Repositories\Eloquent\SchoolRepository;
use App\Repositories\Eloquent\MembershipRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\ClassRepositoryInterface;
use App\Repositories\Contracts\MajorRepositoryInterface;
use App\Repositories\Contracts\SchoolRepositoryInterface;
use App\Repositories\Contracts\MembershipRepositoryInterface;
use App\Repositories\Eloquent\SchoolMembershipSummaryRepository;
use App\Repositories\Contracts\SchoolMembershipSummaryRepositoryInterfaces;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SchoolRepositoryInterface::class, SchoolRepository::class);
        $this->app->bind(MembershipRepositoryInterface::class, MembershipRepository::class);
        $this->app->bind(SchoolMembershipSummaryRepositoryInterfaces::class, SchoolMembershipSummaryRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(MajorRepositoryInterface::class, MajorRepository::class);
        $this->app->bind(ClassRepositoryInterface::class, ClassRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
