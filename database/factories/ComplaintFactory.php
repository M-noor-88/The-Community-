<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Complaint>
 */
class ComplaintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(1,5),
            'location_id' => $this->faker->randomNumber(1,10),
            'complaint_category_id' => $this->faker->randomNumber(1,10),
            'title' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'status' => 'انتظار',
           'region' => $this->faker->word,
            'priority_points' => $this->faker->randomNumber(1,10),
        ];
    }
}
