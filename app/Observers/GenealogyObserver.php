<?php

namespace App\Observers;

use App\Models\Genealogy;
use App\Traits\MiscFuncTrait;

class GenealogyObserver
{
    use MiscFuncTrait;

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

        /**
         * Set default values
         */
        $genealogy->left_available_match_points = 0;
        $genealogy->right_available_match_points = 0;
    }

    /**
     * Handle the Genealogy "created" event.
     *
     * @param  \App\Models\Genealogy  $genealogy
     * @return void
     */
    public function created(Genealogy $genealogy)
    {
        /**
         * Create a new genealogy wallet for newly created genealogy
         */
        $genealogy->genealogyWallet()->create([
            'balance' => 0,
            'accumulated_balance' => 0,
        ]);
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
