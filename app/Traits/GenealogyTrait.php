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
    public static function getGenealogyAncestors(Genealogy $genealogy, int $numberOfAncestors, array $ancestors = [])
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
        return GenealogyTrait::getGenealogyAncestors($referenceGenealogy, $numberOfAncestors, $ancestors);
    }

    /**
     * Award referral bonus to genealogy referrer.
     *
     * @return float
     */
    public static function awardDirectReferralBonusToReferrerGenealogy(Genealogy $genealogy) {

        // Get referrer genealogy
        $referrerGenealogy = $genealogy->referral;

        // Get referrer genealogy wallet
        $referrerGenealogyWallet = $referrerGenealogy->genealogyWallet;

        // Direct Referral Bonus Reward
        $directReferralBonus = 300;

        // Add direct referral bonus to genealogy wallet
        $referrerGenealogyWallet->increment('balance', $directReferralBonus);
        $referrerGenealogyWallet->increment('accumulated_balance', $directReferralBonus);

        // return total award
        return $directReferralBonus;
    }

    /**
     * Award indirect referral bonus to genealogy ancestor.
     *
     * @return float
     */
    public static function awardIndirectReferralBonusToAncestors(Genealogy $ancestor) {
        // return total award
        return 0.00;
    }

    /**
     * Award match bonus to genealogy.
     *
     * @return float
     */
    public static function awardMatchBonusToGenealogy(Genealogy $genealogy) {
        // return total award
        return 0.00;
    }

    /**
     * Check for match bonus
     *
     * @return bool
     */
    public static function checkForMatchBonus(Genealogy $genealogy) {
        // return false if no match bonus
        return false;
    }
}
