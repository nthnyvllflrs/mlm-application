<?php

namespace App\Observers;

use App\Models\Representative;
use Illuminate\Support\Str;

class RepresentativeObserver
{
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
        $representative->code = $this->generateRandomUniqueCode();
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

    /**
     * Generate random unique code for representative
     *
     * @return string
     */
    private function generateRandomUniqueCode() {
        /**
         * Generate random code
         */
        $randomUniqueCode = strtoupper(Str::random(6));

        /**
         * Check if code already exists
         */
        $codeAlreadyExists = Representative::whereCode($randomUniqueCode)->exists();

        /**
         * If code already exists, call this function again
         * to generate new code
         */
        if ($codeAlreadyExists)
            return $this->generateRandomUniqueCode();

        /**
         * Return random unique code
         */
        return $randomUniqueCode;
    }
}
