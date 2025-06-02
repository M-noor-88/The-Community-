<?php

namespace Database\Factories;

use App\Models\CampaignDonationSummary;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignDonationSummaryFactory extends Factory
{
    protected $model = CampaignDonationSummary::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(), // creates a related project by default
            'required_amount' => $this->faker->numberBetween(100, 10000),
            'total_donated' => $this->faker->numberBetween(0, 100),
            'total_donors' => $this->faker->numberBetween(0, 10),
        ];
    }
}
