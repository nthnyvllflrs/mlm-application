<?php

namespace Database\Factories;

use App\Models\Genealogy;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenealogyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genealogy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['STANDARD']),
            'reference_position' => $this->faker->randomElement(['LEFT', 'RIGHT']),
            'left_available_match_points' => 0,
            'right_available_match_points' => 0,
        ];
    }
}
