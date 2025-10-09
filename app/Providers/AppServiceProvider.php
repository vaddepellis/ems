<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Repository\Leave\LeaveInterface;
use App\Repository\Leave\LeaveRepository;
use App\Repository\Attendance\AttendanceInterface;
use App\Repository\Attendance\AttendanceRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       $this->app->bind(LeaveInterface::class,LeaveRepository::class);
       $this->app->bind(AttendanceInterface::class,AttendanceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('delete', function ($user) {
        return $user->isAdmin();
    });
    }
}
