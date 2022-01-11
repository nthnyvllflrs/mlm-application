<?php

namespace App\Traits;

use App\Models\Genealogy;

trait GenealogyTrait
{
    /**
     * Retrieve the ancestors of the passed genealogy.
     *
     * @dev This function is recursive.
     *
     * @return array
     */
    private function getGenealogyAncestors(Genealogy $genealogy, int $numberOfAncestors, array $ancestors = [])
    {
        /**
         * Get genealogy reference genealogy
         */
        $referenceGenealogy = $genealogy->reference;

        /**
         * If the reference genealogy is not null,
         * then add it to the ancestors array,
         * else return ancestors array
         */
        if ($referenceGenealogy) {
            $ancestors[] = $referenceGenealogy;
        } else {
            return $ancestors;
        }

        /**
         * If reference genealogy type is ROOT,
         * return the ancestors array
         */
        if ($referenceGenealogy->type === 'ROOT') {
            return $ancestors;
        }

        /**
         * If the number of ancestors is greater than $numberOfAncestors,
         * return the ancestors array
         */
        if (count($ancestors) >= $numberOfAncestors) {
            return $ancestors;
        }

        /**
         * Call the function again
         */
        return $this->getGenealogyAncestors($referenceGenealogy, $numberOfAncestors, $ancestors);
    }

    /**
     * Award referral bonus to genealogy referrer.
     *
     * @return float
     */
    private function awardDirectReferralBonusToReferrer(Genealogy $referrer) {
        // return total award
        return 0.00;
    }

    /**
     * Award indirect referral bonus to genealogy ancestor.
     *
     * @return float
     */
    private function awardIndirectReferralBonusToAncestor(Genealogy $ancestor) {
        // return total award
        return 0.00;
    }

    /**
     * Award match bonus to genealogy.
     *
     * @return float
     */
    private function awardMatchBonusToGeneaogy(Genealogy $genealogy) {
        // return total award
        return 0.00;
    }

    /**
     * Check for match bonus
     *
     * @return bool
     */
    private function checkForMatchBonus(Genealogy $genealogy) {
        // return false if no match bonus
        return false;
    }
}
