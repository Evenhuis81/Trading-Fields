<?php

namespace App\Providers;

use App\Http\ViewComposers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // dd('hi');
        $norepeat = 'App\Http\ViewComposers\CategoryComposer';
        view()->composer('adverts.edit', $norepeat);
        view()->composer('adverts.create', $norepeat);
        view()->composer('layouts.searchbar', $norepeat);
    }
}
