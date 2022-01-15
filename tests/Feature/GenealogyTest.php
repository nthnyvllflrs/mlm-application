<?php

namespace Tests\Feature;

use App\Models\Genealogy;
use App\Models\Representative;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GenealogyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test retrieve genealogies with pagination
     * for administrator role.
     *
     * @return null
     */
    public function testAdministratorListGenealogies()
    {
        /**
         * Create an administrator
         */
        $administrator = User::factory()->state(['role' => 'ADMINISTRATOR'])->create();

        /**
         * Create genesis genealogy
         */
        $genesisGenealogyId = $this->createGenesisGenealogy();

        /**
         * Create representatives
         */
        User::factory()
            ->count(1)
            ->state(['role' => 'REPRESENTATIVE'])
            ->create()
            ->each(function ($user) use ($genesisGenealogyId) {
                /**
                 * Create a representative
                 */
                $representative = Representative::factory()->create(['user_id' => $user->id]);

                /**
                 * Create a genealogy
                 */
                Genealogy::factory()->create([
                    'representative_id' => $representative->id,
                    'referral_id' => $genesisGenealogyId,
                    'reference_id' => $genesisGenealogyId,
                ]);
            });

        /**
         * Authenticate administrator
         * for the test request
         */
        Sanctum::actingAs($administrator);

        /**
         * Test
         */
        $this->getJson(route('genealogies.index'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [[
                    'id', 'code', 'type',
                    'reference_position',
                    'referral', 'reference',
                    'left_available_match_points',
                    'right_available_match_points',
                ]],
                'links', 'meta'
            ]);
    }

    /**
     * Test create genealogy
     * for administrator role.
     *
     * @return null
     */
    public function testAdministratorCreateGenealogy()
    {
        /**
         * Create an administrator
         */
        $administrator = User::factory()->state(['role' => 'ADMINISTRATOR'])->create();

        /**
         * Create genesis genealogy
         */
        $genesis = $this->createGenesisGenealogy();

        /**
         * Create representative
         */
        $user = User::factory()->state(['role' => 'REPRESENTATIVE'])->create();
        $representative = Representative::factory()->create(['user_id' => $user->id]);

        /**
         * Genealogy data
         */
        $genealogyData = [
            'representative_id' => $representative->id,
            'type' => 'STANDARD',
            'referral_id' => $genesis->id,
            'reference_id' => $genesis->id,
            'reference_position' => 'LEFT'
        ];

        /**
         * Authenticate administrator
         * for the test request
         */
        Sanctum::actingAs($administrator);

        /**
         * Test
         */
        $this->postJson(route('genealogies.store', $genealogyData))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id', 'code', 'type',
                    'reference_position',
                    'referral', 'reference',
                    'left_available_match_points',
                    'right_available_match_points',
                ],
            ]);

        /**
         * Check if referral reward bonus was awarded
         */
        $genesisGenealogyWallet = $genesis->genealogyWallet;

        /**
         * Check genesis genealogy wallet values
         * 300, is the default value for direct referral, to check go to
         * GenealogyTrait@awardDirectReferralBonusToReferrerGenealogy()
         * plus
         * 3, is the default value for indirect referral, to check go to
         * GenealogyTrait@awardIndirectReferralBonusToReferrerGenealogy()
         */
        $this->assertEquals(303, $genesisGenealogyWallet->balance);
        $this->assertEquals(303, $genesisGenealogyWallet->accumulated_balance);
    }

    /**
     * Test show genealogy
     * for administrator role.
     *
     * @return null
     */
    public function testAdministratorShowGenealogy()
    {
        /**
         * Create an administrator
         */
        $administrator = User::factory()
            ->state(['role' => 'ADMINISTRATOR'])
            ->create();

        /**
         * Create genesis genealogy
         */
        $genesisGenealogyId = $this->createGenesisGenealogy();

        /**
         * Create representatives
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
            'referral_id' => $genesisGenealogyId,
            'reference_id' => $genesisGenealogyId,
        ]);

        /**
         * Authenticate administrator
         * for the test request
         */
        Sanctum::actingAs($administrator);

        /**
         * Test
         */
        $this->getJson(route('genealogies.show', ['genealogy' => $genealogy->id]))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id', 'code', 'type',
                    'reference_position',
                    'referral', 'reference',
                    'left_available_match_points',
                    'right_available_match_points',
                ],
            ]);
    }

    /**
     * Test update genealogy
     * for administrator role.
     *
     * @return null
     */
    public function testAdministratorUpdateGenealogy()
    {
        /**
         * Create an administrator
         */
        $administrator = User::factory()
            ->state(['role' => 'ADMINISTRATOR'])
            ->create();

        /**
         * Create genesis genealogy
         */
        $genesisGenealogyId = $this->createGenesisGenealogy();

        /**
         * Create representatives
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
            'referral_id' => $genesisGenealogyId,
            'reference_id' => $genesisGenealogyId,
        ]);

        /**
         * Authenticate administrator
         * for the test request
         */
        Sanctum::actingAs($administrator);

        /**
         * Test
         */
        $this->putJson(route('genealogies.update', ['genealogy' => $genealogy->id]))
            ->assertSuccessful()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * Test delete genealogy
     * for administrator role.
     *
     * @return null
     */
    public function testAdministratorDeleteGenealogy()
    {
        /**
         * Create an administrator
         */
        $administrator = User::factory()
            ->state(['role' => 'ADMINISTRATOR'])
            ->create();

        /**
         * Create genesis genealogy
         */
        $genesisGenealogyId = $this->createGenesisGenealogy();

        /**
         * Create representatives
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
            'referral_id' => $genesisGenealogyId,
            'reference_id' => $genesisGenealogyId,
        ]);

        /**
         * Authenticate administrator
         * for the test request
         */
        Sanctum::actingAs($administrator);

        /**
         * Test
         */
        $this->deleteJson(route('genealogies.update', ['genealogy' => $genealogy->id]))
            ->assertSuccessful()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * Create the genesis genealogy
     *
     * @return Genealogy
     */
    public static function createGenesisGenealogy()
    {
        /**
         * Create the genesis genealogy
         */
        $user = User::factory()->state(['role' => 'REPRESENTATIVE'])
            ->create();

        $representative = Representative::factory()
            ->create(['user_id' => $user->id]);

        $genesis = Genealogy::factory()
            ->create([
                'representative_id' => $representative->id,
                'referral_id' => null,
                'reference_id' => null,
                'reference_position' => 'HEAD',
                'type' => 'GENESIS'
            ]);

        /**
         * Return the genesis genealogy id
         */
        return $genesis;
    }
}
