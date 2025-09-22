<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Leave\LeaveInterface;
use App\Repository\Leave\LeaveRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       $this->app->bind(LeaveInterface::class,LeaveRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
