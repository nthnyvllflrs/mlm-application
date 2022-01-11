<?php

namespace App\Observers;

use App\Models\GenealogyWallet;

class GenealogyWalletObserver
{
    /**
     * Handle the GenealogyWallet "created" event.
     *
     * @param  \App\Models\GenealogyWallet  $genealogyWallet
     * @return void
     */
    public function created(GenealogyWallet $genealogyWallet)
    {
        //
    }

    /**
     * Handle the GenealogyWallet "updated" event.
     *
     * @param  \App\Models\GenealogyWallet  $genealogyWallet
     * @return void
     */
    public function updated(GenealogyWallet $genealogyWallet)
    {
        //
    }

    /**
     * Handle the GenealogyWallet "deleted" event.
     *
     * @param  \App\Models\GenealogyWallet  $genealogyWallet
     * @return void
     */
    public function deleted(GenealogyWallet $genealogyWallet)
    {
        //
    }

    /**
     * Handle the GenealogyWallet "restored" event.
     *
     * @param  \App\Models\GenealogyWallet  $genealogyWallet
     * @return void
     */
    public function restored(GenealogyWallet $genealogyWallet)
    {
        //
    }

    /**
     * Handle the GenealogyWallet "force deleted" event.
     *
     * @param  \App\Models\GenealogyWallet  $genealogyWallet
     * @return void
     */
    public function forceDeleted(GenealogyWallet $genealogyWallet)
    {
        //
    }
}
