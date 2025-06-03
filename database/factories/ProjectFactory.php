<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Image;
use App\Models\Location;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Project::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // assuming User model exists
            'image_id' => 1 , // or use a fake value if required
            'category_id' => 1 ,
            'location_id' => 1 ,
            'number_of_participant' => $this->faker->numberBetween(10, 100),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'Execution_date' => $this->faker->date,
            'type' => 'مبادرة', // Must be 'مبادرة' for voting to work
            'status' => 'تصويت', // or whatever default makes sense
            'created_by' => "user",
        ];
    }
}
