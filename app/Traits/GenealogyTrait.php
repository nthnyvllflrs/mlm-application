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
    public function getGenealogyAncestors(Genealogy $genealogy, int $numberOfAncestors, array $ancestors = [])
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
    public function awardDirectReferralBonusToReferrerGenealogy(Genealogy $genealogy)
    {

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
    public function awardIndirectReferralBonusToAncestor(Genealogy $ancestor)
    {

        // Get  ancestor wallet
        $ancestorWallet = $ancestor->genealogyWallet;

        // Indirect Referral Bonus Reward
        $indirectReferralBonus = 3;

        // Add indirect referral bonus to ancestor wallet
        $ancestorWallet->increment('balance', $indirectReferralBonus);
        $ancestorWallet->increment('accumulated_balance', $indirectReferralBonus);

        // return total award
        return $indirectReferralBonus;
    }

    /**
     * Award match bonus to genealogy.
     *
     * @return float
     */
    public function awardMatchBonusToGenealogy(Genealogy $genealogy, int $matchPoints)
    {
        // Get ancestor genealogy wallet
        $genealogyWallet = $genealogy->genealogyWallet;

        // Match Bonus Reward
        $matchBonus = 600 * $matchPoints;

        // Add direct referral bonus to genealogy wallet
        $genealogyWallet->increment('balance', $matchBonus);
        $genealogyWallet->increment('accumulated_balance', $matchBonus);

        // return total award
        return $matchBonus;
    }

    /**
     * Check for match bonus
     *
     * @return bool
     */
    public function checkForMatchBonus(Genealogy $genealogy)
    {
        // return 0 if no match bonus
        return 0;
    }

    /**
     * On new genealogy created
     * Todo list:
     *      Direct Referral Bonus - Referral Genealogy
     *      Indirect Referral Bonus - Ancestors
     *      Match Bonus - Ancestors
     *
     * @return void
     */
    public function onNewGenealogyCreated(Genealogy $genealogy)
    {
        // Award direct referral bonus to referrer genealogy
        $this->awardDirectReferralBonusToReferrerGenealogy($genealogy);

        // Get ancestors of new genealogy, up to 10 genealogies
        $ancestors = $this->getGenealogyAncestors($genealogy, 10);

        // Loop through each ancestor
        foreach ($ancestors as $index => $ancestor) {
            // Indirect Referral
            $this->awardIndirectReferralBonusToAncestor($ancestor);

            // Check for match bonus
            $matchPoints = $this->checkForMatchBonus($ancestor);

            // Award match bonus to genealogy
            $this->awardMatchBonusToGenealogy($ancestor, $matchPoints);
        }
    }
}
