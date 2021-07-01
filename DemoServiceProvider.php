<?php

namespace Windqyoung\DemoService;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class DemoServiceProvider extends ServiceProvider
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
    public function boot()
    {
        //
        $this->registerCommands();
        $this->registerRoutes();
    }

    private function registerRoutes()
    {
        if (is_file(__DIR__ . '/App/routes.php')) {
            Route::group(['prefix' => '/demo'], function () {
                $this->loadRoutesFrom(__DIR__ . '/App/routes.php');
            });
        }
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
