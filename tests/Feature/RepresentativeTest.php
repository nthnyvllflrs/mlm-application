<?php

namespace Tests\Feature;

use App\Models\Representative;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RepresentativeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test retrieve representatives with pagination
     * for administrator role.
     *
     * @return null
     */
    public function testAdministratorListRepresentative()
    {
        /**
         * Create an administrator
         */
        $administrator = User::factory()->state(['role' => 'ADMINISTRATOR'])->create();

        /**
         * Create representatives
         */
        User::factory()->state(['role' => 'REPRESENTATIVE'])->create()->each(function ($user) {
            Representative::factory()->create(['user_id' => $user->id]);
        });

        /**
         * Authenticate administrator
         * for the test request
         */
        Sanctum::actingAs($administrator);

        /**
         * Test
         */
        $this->getJson(route('representatives.index'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [[
                    'id', 'name', 'contact_number',
                    'user' => ['id', 'username']
                ]],
                'links', 'meta'
            ]);
    }

    /**
     * Test create representative
     * for administrator role.
     *
     * @return null
     */
    public function testAdministratorCreateRepresentative()
    {
        /**
         * Create an administrator
         */
        $administrator = User::factory()->state(['role' => 'ADMINISTRATOR'])->create();

        /**
         * Representative data
         */
        $data = [
            'username' => $this->faker->userName(),
            'password' => 'password',
            'password_confirmation' => 'password',

            'name' => $this->faker->name,
            'contact_number' => $this->faker->phoneNumber
        ];

        /**
         * Authenticate administrator
         * for the test request
         */
        Sanctum::actingAs($administrator);

        /**
         * Test
         */
        $this->postJson(route('representatives.store'), $data)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id', 'name', 'contact_number',
                    'user' => ['id', 'username']
                ]
            ]);
    }

    /**
     * Test show representatives
     * for administrator roles
     *
     * @return null
     */
    public function testAdministratorShowRepresentative()
    {
        /**
         * Create an administrator
         */
        $administrator = User::factory()->state(['role' => 'ADMINISTRATOR'])->create();

        /**
         * Create representative
         */
        $user = User::factory()->state(['role' => 'REPRESENTATIVE'])->create();
        $representative = Representative::factory()->create(['user_id' => $user->id]);

        /**
         * Authenticate administrator
         * for the test request
         */
        Sanctum::actingAs($administrator);

        /**
         * Test
         */
        $this->getJson(route('representatives.show', ['representative' => $representative->id]))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id', 'name', 'contact_number',
                    'user' => ['id', 'username']
                ]
            ]);
    }

    /**
     * Test update representative
     * for administrator roles
     *
     * @return null
     */
    public function testAdministratorUpdateRepresentative()
    {
        /**
         * Create an administrator
         */
        $administrator = User::factory()->state(['role' => 'ADMINISTRATOR'])->create();

        /**
         * Create representative
         */
        $user = User::factory()->state(['role' => 'REPRESENTATIVE'])->create();
        $representative = Representative::factory()->create(['user_id' => $user->id]);

        /**
         * Updated representative data
         */
        $data = [
            'representative' => $representative->id,

            'username' => $this->faker->userName(),
            'password' => 'password',
            'password_confirmation' => 'password',

            'name' => $this->faker->name,
            'contact_number' => $this->faker->phoneNumber
        ];

        /**
         * Authenticate administrator
         */
        Sanctum::actingAs($administrator);

        $this->putJson(route('representatives.update', $data))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id', 'name', 'contact_number',
                    'user' => ['id', 'username']
                ]
            ]);
    }

    /**
     * Test delete representative
     * for administrator roles
     *
     * @return null
     */
    public function testAdmisnitratorDeleteRepresentative()
    {
        /**
         * Create an administrator
         */
        $administrator = User::factory()->state(['role' => 'ADMINISTRATOR'])->create();

        /**
         * Create representative
         */
        $user = User::factory()->state(['role' => 'REPRESENTATIVE'])->create();
        $representative = Representative::factory()->create(['user_id' => $user->id]);

        /**
         * Authenticate administrator
         */
        Sanctum::actingAs($administrator);

        /**
         * Test
         */
        $this->deleteJson(route('representatives.destroy', ['representative' => $representative->id]))
            ->assertSuccessful();

        /**
         * Assert database
         */

         /**
          * Check if representative was deleted
          */
        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);

        /**
         * Check if user was deleted
         */
        $this->assertDatabaseMissing('representatives', [
            'id' => $representative->id
        ]);
    }
}
