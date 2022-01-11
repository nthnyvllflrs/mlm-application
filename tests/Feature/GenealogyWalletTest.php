<?php

namespace Tests\Feature;

use App\Models\Genealogy;
use App\Models\Representative;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GenealogyWalletTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test retrieve genealogy wallets with pagination
     * for administrator role.
     *
     * @return null
     */
    public function testAdministratorListGenealogyWallets()
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
        $genesisGenealogyId = GenealogyTest::createGenesisGenealogy();

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
        $this->getJson(route('genealogyWallets.index'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [[
                    'id', 'balance', 'accumulated_balance',
                    'genealogy' => [
                        'id', 'code', 'type',
                        'reference_position',
                        'left_available_match_points',
                        'right_available_match_points',
                    ]
                ]],
            ]);
    }

    /**
     * Test retrieve genealog wallets
     * for administrator role.
     *
     * @return null
     */
    public function testAdministratorShowGenealogyWallet()
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
        $genesisGenealogyId = GenealogyTest::createGenesisGenealogy();

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
        $this->getJson(route('genealogyWallets.show', ['genealogyWallet' => $genealogy->genealogyWallet->id]))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id', 'balance', 'accumulated_balance',
                    'genealogy' => [
                        'id', 'code', 'type',
                        'reference_position',
                        'left_available_match_points',
                        'right_available_match_points',
                    ]
                ],
            ]);
    }
}
