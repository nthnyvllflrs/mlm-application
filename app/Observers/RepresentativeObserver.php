<?php

namespace App\Observers;

use App\Models\Representative;
use App\Traits\MiscFuncTrait;

class RepresentativeObserver
{
    use MiscFuncTrait;

    /**
     * Handle the Representative "creating" event.
     *
     * @param  \App\Models\Representative  $representative
     * @return void
     */
    public function creating(Representative $representative)
    {
        /**
         * Generate unique code for new representative
         */
        $representative->code = $this->generateRandomUniqueCode(Representative::class, 6);
    }

    /**
     * Handle the Representative "created" event.
     *
     * @param  \App\Models\Representative  $representative
     * @return void
     */
    public function created(Representative $representative)
    {
        //
    }

    /**
     * Handle the Representative "updated" event.
     *
     * @param  \App\Models\Representative  $representative
     * @return void
     */
    public function updated(Representative $representative)
    {
        //
    }

    /**
     * Handle the Representative "deleted" event.
     *
     * @param  \App\Models\Representative  $representative
     * @return void
     */
    public function deleted(Representative $representative)
    {
        //
    }

    /**
     * Handle the Representative "restored" event.
     *
     * @param  \App\Models\Representative  $representative
     * @return void
     */
    public function restored(Representative $representative)
    {
        //
    }

    /**
     * Handle the Representative "force deleted" event.
     *
     * @param  \App\Models\Representative  $representative
     * @return void
     */
    public function forceDeleted(Representative $representative)
    {
        //
    }
}
