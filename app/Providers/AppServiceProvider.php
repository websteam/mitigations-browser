<?php

namespace App\Providers;

use App\Repository\TacticRepositoryInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(TacticRepositoryInterface $tacticRepository)
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function ($view) use ($tacticRepository) {
            $view->with('globalTactics', $tacticRepository->all());
        });
    }
}
