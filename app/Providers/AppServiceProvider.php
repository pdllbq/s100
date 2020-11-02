<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Post;
use App\Models\Group;
use App\Observers\PostObserver;
use App\Observers\GroupObserver;

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
    public function boot()
    {
        //MariaDB < 10.2.2
        \Schema::defaultStringLength(191);
        \Schema::enableForeignKeyConstraints();
		
		Post::observe(PostObserver::class);
		Group::observe(GroupObserver::class);
    }
}
