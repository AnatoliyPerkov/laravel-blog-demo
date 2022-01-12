<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Observers\BlogCategoryObserver;
use App\Observers\BlogPostObserver;
use App\Observers\BlogUserObserver;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
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
    public function boot()
    {
        Post::observe(BlogPostObserver::class);
        Category::observe(BlogCategoryObserver::class);
        User::observe(BlogUserObserver::class);

        Gate::define('admin-panel', function (User $user) {
            return $user->hasRole('Admin')
                ? Response::allow()
                : Response::deny('You must be a super administrator.');
        });

        Gate::define('cabinet-panel', function (User $user) {
            return $user->hasRole('Author')
                ? Response::allow()
                : Response::deny('You must be a cabinet.');
        }
        );
    }
}
