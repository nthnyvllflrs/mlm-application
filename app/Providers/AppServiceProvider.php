<?php

namespace App\Providers;

use App\Models\Genealogy;
use App\Models\Representative;
use App\Observers\GenealogyObserver;
use App\Observers\RepresentativeObserver;
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

        /**
         * Model abservers
         */
        Representative::observe(RepresentativeObserver::class);
        Genealogy::observe(GenealogyObserver::class);
    }
}
