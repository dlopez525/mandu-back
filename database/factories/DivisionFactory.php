<?php

namespace Database\Factories;

use App\Models\Ambassador;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Division>
 */
class DivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ambassador = Ambassador::factory()->create();
        return [
            'name' => $this->faker->company . " " . Str::random(5),
            'level' => $this->faker->numberBetween(1, 5),
            'number_collaborators' => $this->faker->numberBetween(1, 100),
            'ambassador_id' => $ambassador,
        ];
    }
}
