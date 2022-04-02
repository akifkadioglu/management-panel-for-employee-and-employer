<?php

namespace App\Providers;

use App\Models\Other;
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
        $data = Other::first();
        if (empty($data)) {
            $data = new Other();
            $data->price = 5;
            $data->save();
        }
    }
}
