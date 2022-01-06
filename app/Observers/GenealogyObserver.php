<?php

namespace App\Observers;

use App\Models\Genealogy;
use App\Traits\MiscFunction;

class GenealogyObserver
{
    use MiscFunction;

    /**
     * Handle the Genealogy "creating" event.
     *
     * @param  \App\Models\Genealogy  $genealogy
     * @return void
     */
    public function creating(Genealogy $genealogy)
    {
        /**
         * Generate unique code for new genealogy
         */
        $genealogy->code = $this->generateRandomUniqueCode(Genealogy::class, 6);
    }

    /**
     * Handle the Genealogy "created" event.
     *
     * @param  \App\Models\Genealogy  $genealogy
     * @return void
     */
    public function created(Genealogy $genealogy)
    {
        //
    }

    /**
     * Handle the Genealogy "updated" event.
     *
     * @param  \App\Models\Genealogy  $genealogy
     * @return void
     */
    public function updated(Genealogy $genealogy)
    {
        //
    }

    /**
     * Handle the Genealogy "deleted" event.
     *
     * @param  \App\Models\Genealogy  $genealogy
     * @return void
     */
    public function deleted(Genealogy $genealogy)
    {
        //
    }

    /**
     * Handle the Genealogy "restored" event.
     *
     * @param  \App\Models\Genealogy  $genealogy
     * @return void
     */
    public function restored(Genealogy $genealogy)
    {
        //
    }

    /**
     * Handle the Genealogy "force deleted" event.
     *
     * @param  \App\Models\Genealogy  $genealogy
     * @return void
     */
    public function forceDeleted(Genealogy $genealogy)
    {
        //
    }
}
