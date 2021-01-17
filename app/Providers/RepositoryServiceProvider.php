<?php

namespace App\Providers;

use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\TacticRepository;
use App\Repository\Eloquent\TechniqueRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\TacticRepositoryInterface;
use App\Repository\TechniqueRepositoryInterface;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(TacticRepositoryInterface::class, TacticRepository::class);
        $this->app->bind(TechniqueRepositoryInterface::class, TechniqueRepository::class);
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
