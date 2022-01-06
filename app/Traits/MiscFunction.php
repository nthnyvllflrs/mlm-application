<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait MiscFunction
{
    /**
     * Generate random unique code for representative
     *
     * @return string
     */
    private function generateRandomUniqueCode($model, $length)
    {
        /**
         * Generate random code
         */
        $randomUniqueCode = strtoupper(Str::random($length));

        /**
         * Check if code already exists
         */
        $codeAlreadyExists = $model::whereCode($randomUniqueCode)->exists();

        /**
         * If code already exists, call this function again
         * to generate new code
         */
        if ($codeAlreadyExists)
            return $this->generateRandomUniqueCode($model, $length);

        /**
         * Return random unique code
         */
        return $randomUniqueCode;
    }
}
