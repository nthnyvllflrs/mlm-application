<?php

namespace Tests\Unit;

use App\Models\Genealogy;
use App\Models\Representative;
use App\Models\User;
use App\Traits\GenealogyTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase, GenealogyTrait;

    /**
     * Test that GenealogyTrait::getGenealogyAncestors() works
     *
     * @return null
     */
    public function testGenealogyTraitGetGenealogyAncestorsFunc()
    {
        /**
         * Create the head genealogy
         */
        $user = User::factory()->state(['role' => 'REPRESENTATIVE'])
            ->create();

        $representative = Representative::factory()
            ->create(['user_id' => $user->id]);

        $headGenealogy = Genealogy::factory()
            ->create([
                'representative_id' => $representative->id,
                'referral_id' => null,
                'reference_id' => null,
                'reference_position' => 'HEAD',
                'type' => 'HEAD'
            ]);

        /**
         * Create representative
         */
        $user = User::factory()
            ->state(['role' => 'REPRESENTATIVE'])
            ->create();

        /**
         * Create a representative
         */
        $representative = Representative::factory()
            ->create(['user_id' => $user->id]);

        /**
         * Create a genealogy
         */
        $genealogy = Genealogy::factory()->create([
            'representative_id' => $representative->id,
            'referral_id' => $headGenealogy->id,
            'reference_id' => $headGenealogy->id,
        ]);

        /**
         * Test GenealogyTrait::getGenealogyAncestors()
         */
        $ancestors = $this->getGenealogyAncestors($genealogy, 10);

        /**
         * Assert that the ancestors array has the correct number of elements
         */
        $this->assertEquals(count($ancestors), 1);

        /**
         * Assert that the first ancestor is the HEAD genealogy
         */
        $this->assertEquals('HEAD', $ancestors[0]->type);
    }
}
