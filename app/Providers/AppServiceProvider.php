<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RagService;
use Doctrine\ORM\EntityManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
