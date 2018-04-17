<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::Share('publicUrl', getenv('PUBLIC_URL'));
        View::Share('adminUrl', getenv('ADMIN_URL'));
        View::Share('imgUrl', getenv('IMAGES_URL'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
