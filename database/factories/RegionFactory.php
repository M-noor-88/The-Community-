<?php
namespace Database\Factories;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegionFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->city,
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'points' => $this->faker->randomNumber(1,10),
        ];
    }
}
