<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Post;
use App\Models\Group;
use App\Observers\PostObserver;
use App\Observers\GroupObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //if ($this->app->isLocal()) {
			$this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
			$this->app->register(TelescopeServiceProvider::class);
		//}
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //MariaDB < 10.2.2
        Schema::defaultStringLength(191);
        Schema::enableForeignKeyConstraints();

				Post::observe(PostObserver::class);
				Group::observe(GroupObserver::class);

				Paginator::useBootstrap();
    }
}
